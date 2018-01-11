<?php
namespace App\Builders;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Base\Presenter;
use App\Base\Repository;

use App\Repositories\Criterias\Common\OrderResolvedByUrlCriteria;

class PaginationBuilder
{
    private $data;
    private $perPage;
    private $presenter;
    private $criterias;
    private $repository;
    private $originalRepository;

    public function __construct()
    {
        $this->perPage    = config('pagination.per_page_default');
        $this->criterias  = collect($this->getDefaultCriterias());
        $this->presenter  = null;
        $this->repository = null;
    }

    /**
     * Configura a classe para paginar um repositório
     *
     * @param App\Base\Repository $repository
     * @return App\Builders\PaginationBuilder
     */
    public function repository(Repository $repository)
    {
        $this->data = null;
        $this->repository = $repository;
        $this->originalRepository = clone $repository;
        return $this;
    }

    /**
     * Configura a classe para paginar uma Collection
     *
     * @param Illuminate\Support\Collection $collection
     * @return App\Builders\PaginationBuilder
     */
    public function fromCollection(Collection $collection)
    {
        $this->repository = null;
        $this->originalRepository = null;
        $this->data = $collection;
        return $this;
    }

    /**
     * Define um Presenter para os ítens paginados
     *
     * Este método permite definir um único Presenter para formatar
     * todos os elementos paginados.
     *
     * @param App\Base\Presenter $presenter
     * @return App\Builders\PaginationBuilder
     */
    public function presenter($presenter)
    {
        if (!$presenter instanceof Presenter) {
            throw new \Exception("The presenter passed as argument is not a instance of App\Base\Presenter", 1);
        }

        $this->presenter = $presenter;

        return $this;
    }

    /**
     * Adiciona critérios para filtro da paginação
     *
     * Este método permite definir critérios de filtro para a paginação
     * Os critérios podem ou não estar dentro de uma coleção.
     *
     * @param Illuminate\Support\Collection $criterias
     * @return App\Builders\PaginationBuilder
     */
    public function criterias($criterias)
    {
        if ($criterias instanceof Collection) {
            $this->criterias->merge($criterias);
        } else {
            $this->criterias->merge(collect($criterias));
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
        $this->criterias = collect();
        return $this;
    }

    /**
     * Define a quantidade de ítens por página
     *
     * @param int $perPage
     * @return App\Builders\PaginationBuilder
     */
    public function perPage(int $perPage)
    {
        $this->per_page = $perPage;
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
            return $this->buildForRepository();
        } else {
            return $this->buildForDataCollection();
        }
    }

    private function buildForRepository()
    {
        foreach ($this->criterias as $criteria) {
            $this->repository->pushCriteria($criteria);
        }

        if ($this->presenter == null) {
            return $this->repository->paginate($this->perPage);
        }

        $total = $this->repository->count();
        $data  = $this->repository->paginate($this->perPage)->items();
        $data  = collect($data);

        $presented_data = $this->presenter->get($data);
        return $this->getPaginationFromCollection($presented_data, $total);
    }

    private function buildForDataCollection()
    {
        if (!$this->data) {
            $this->data = collect();
        }

        if ($this->presenter == null) {
            $data = $this->data;
        } else {
            $data = $this->presenter->get($this->data);
        }

        return $this->getPaginationFromCollection($data);
    }

    private function getPaginationFromCollection($collection, $total = null)
    {
        if (!$collection instanceof Collection) {
            $collection = collect($collection);
        }

        $perPage = $this->perPage;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $collection;

        if ($total == null) {
            $total = $collection->count();
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);
        }

        return new LengthAwarePaginator($currentPageItems, $total, $perPage);
    }

    private function getDefaultCriterias()
    {
        $default_criterias[] = new OrderResolvedByUrlCriteria();

        return $default_criterias;
    }
}
