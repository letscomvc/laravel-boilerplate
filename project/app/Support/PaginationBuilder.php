<?php

namespace App\Support;

use App\Repositories\Criterias\Common\OrderResolvedByUrlCriteria;
use App\Repositories\Criterias\Common\SearchResolvedByUrlCriteria;
use App\Repositories\Repository;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PaginationBuilder implements Responsable
{
    private $perPage;
    private $resource;
    private $criteria;
    private $collection;
    private $repository;
    private $defaultOrderBy;
    private $originalRepository;

    public function __construct()
    {
        $this->perPage = config('pagination.per_page_default');
        $this->resource = null;
        $this->criteria = collect();
        $this->repository = null;
    }

    /**
     * Configura a classe para paginar um repositório
     *
     * Pode receber uma instância de repositório ou sua respectiva classe.
     *
     * @param  App\Repositories\Repository  $repository
     * @return App\Builders\PaginationBuilder
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
     * @param  Illuminate\Support\Collection  $collection
     * @return App\Builders\PaginationBuilder
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
     * @param  Illuminate\Http\Resources\Json\JsonResource  $resource
     * @return App\Support\PaginationBuilder
     */
    public function resource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Adiciona critérios para filtro da paginação
     *
     * Este método permite definir critérios de filtro para a paginação
     * Os critérios podem ou não estar dentro de uma coleção.
     *
     * @param  Illuminate\Support\Collection  $criterias
     * @return App\Builders\PaginationBuilder
     */
    public function criterias($criterias)
    {
        if ($criterias instanceof Collection) {
            $this->criteria = $this->criteria->merge($criterias);
        } else {
            $this->criteria->push($criterias);
        }

        return $this;
    }

    /**
     * Remove critérios de filtros
     *
     * @return App\Builders\PaginationBuilder
     */
    public function cleanCriterias()
    {
        $this->criteria = collect();
        return $this;
    }

    /**
     * Define a quantidade de ítens por página
     *
     * @param  int  $perPage
     * @return App\Builders\PaginationBuilder
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
     * @return Illuminate\Pagination\LengthAwarePaginator
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

    /**
     * Define critérios padrões para todas as paginações.
     *
     * Os critérios podem ser anulados utilizando o método 'cleanCriterias'.
     *
     * @return array
     */
    private function getDefaultCriterias()
    {
        $defaultCriterias[] = new OrderResolvedByUrlCriteria($this->defaultOrderBy ?? []);
        $defaultCriterias[] = new SearchResolvedByUrlCriteria();

        return $defaultCriterias;
    }

    private function buildForRepository()
    {
        $defaultCriterias = collect($this->getDefaultCriterias());
        $criterias = $this->criteria
            ->merge($defaultCriterias);

        $this->repository->pushCriteria($criterias);

        return $this->repository->paginate($this->perPage);
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

        return $this->collection->paginate($this->perPage);
    }
}
