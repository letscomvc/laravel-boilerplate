<?php

namespace App\Support;

use App\Repositories\Criteria\Common\OrderResolvedByUrlCriteria;
use App\Repositories\Criteria\Common\SearchResolvedByUrlCriteria;
use App\Repositories\Repository;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PaginationBuilder implements Responsable
{
    public const PER_PAGE_DEFAULT = 30;

    private $perPage;
    private $resource;
    private $criteria;
    private $collection;
    private $repository;
    private $simplePaginate;
    private $defaultOrderBy;
    private $originalRepository;

    public function __construct()
    {
        $this->perPage = static::PER_PAGE_DEFAULT;
        $this->resource = null;
        $this->criteria = collect();
        $this->repository = null;
    }

    /**
     * Configura a classe para paginar um repositório
     *
     * Pode receber uma instância de repositório ou sua respectiva classe.
     *
     * @param  \App\Repositories\Repository|string  $repository
     * @return $this
     */
    public function repository($repository)
    {
        if (!($repository instanceof Repository)) {
            $repository = new $repository();
        }

        $this->collection = null;
        $this->repository = $repository;
        $this->originalRepository = clone $repository;

        return $this;
    }

    /**
     * Configura a classe para paginar uma Collection
     *
     * @param  \Illuminate\Support\Collection  $collection
     * @return $this
     */
    public function collection(Collection $collection)
    {
        $this->repository = null;
        $this->collection = $collection;
        $this->originalRepository = null;

        return $this;
    }

    /**
     * Define um Resource para os ítens paginados
     *
     * Este método permite definir um único Resource para formatar
     * todos os elementos paginados.
     *
     * @param  \Illuminate\Http\Resources\Json\JsonResource|string  $resource
     * @return $this
     */
    public function resource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Define se a paginação sera uma paginação convencional ou uma paginação simples.
     *
     * https://laravel.com/docs/5.8/pagination#basic-usage
     *
     * @param  boolean  $isSimplePagination
     * @return self
     */
    public function simplePaginate($isSimplePagination = true)
    {
        $this->simplePaginate = $isSimplePagination;

        return $this;
    }

    /**
     * Adiciona critérios para filtro da paginação
     *
     * Este método permite definir critérios de filtro para a paginação
     * Os critérios podem ou não estar dentro de uma coleção.
     *
     * @param  \Illuminate\Support\Collection  $criteria
     * @return $this
     */
    public function criteria($criteria)
    {
        if ($criteria instanceof Collection) {
            $this->criteria = $this->criteria->merge($criteria);
        } else {
            $this->criteria->push($criteria);
        }

        return $this;
    }

    /**
     * Remove critérios de filtros
     *
     * @return $this
     */
    public function cleanCriteria()
    {
        $this->criteria = collect();
        return $this;
    }

    /**
     * Define a quantidade de ítens por página
     *
     * @param  int  $perPage
     * @return $this
     */
    public function perPage(int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Define a ordem padrão de ordenação.
     *
     * @param  $field
     * @param  $order
     * @return self
     */
    public function defaultOrderBy($field, $order = 'desc')
    {
        $this->defaultOrderBy = [
            'field' => $field,
            'order' => strtolower($order),
        ];

        return $this;
    }

    /**
     * Constrói e retorna a paginação
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function build()
    {
        if ($this->repository != null) {
            $paginated = $this->buildForRepository();
        } else {
            $paginated = $this->buildForCollection();
        }

        if ($this->resource) {
            return $this->resource::collection($paginated);
        }

        return JsonResource::collection($paginated);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return $this->build()
            ->response();
    }

    private function getPerPage()
    {
        $perPage = \Request::input('perPage', $this->perPage);
        if ($perPage > 100 || $perPage < 1) {
            $message = "Per page parameter [{$perPage}] out of the range.";
            throw new UnauthorizedHttpException($message);
        }

        return $perPage;
    }

    /**
     * Define critérios padrões para todas as paginações.
     *
     * Os critérios podem ser anulados utilizando o método 'cleanCriteria'.
     *
     * @return array
     */
    private function getDefaultCriteria()
    {
        return [
            new OrderResolvedByUrlCriteria($this->defaultOrderBy ?? []),
            new SearchResolvedByUrlCriteria(),
        ];
    }

    private function buildForRepository()
    {
        $defaultCriteria = collect($this->getDefaultCriteria());
        $criteria = $this->criteria->merge($defaultCriteria);
        $this->repository->pushCriteria($criteria);

        $simplePaginate = $this->simplePaginate;

        if ($simplePaginate) {
            return $this->repository->simplePaginate($this->getPerPage());
        }

        return $this->repository->paginate($this->getPerPage());
    }

    private function buildForCollection()
    {
        if (!$this->collection) {
            $this->collection = collect();
        }

        if (!$this->collection instanceof Collection) {
            $this->collection = collect($this->collection);
        }

        if ($this->defaultOrderBy) {
            $order = array_get($this->defaultOrderBy, 'order');
            $field = array_get($this->defaultOrderBy, 'field');
            if ($order == 'desc') {
                $this->collection = $this->collection->sortByDesc($field);
            } else {
                $this->collection = $this->collection->sortBy($field);
            }
        }

        return $this->collection->paginate($this->getPerPage());
    }
}