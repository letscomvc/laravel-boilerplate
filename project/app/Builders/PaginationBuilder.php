<?php
namespace App\Builders;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Base\Presenter;

use App\Repositories\Criterias\Common\OrderResolvedByUrlCriteria;

class PaginationBuilder
{
    private $repository;
    private $criterias;
    private $perPage;
    private $presenter;
    private $data;

    public function __construct()
    {
        $this->repository = null;
        $this->criterias = collect($this->getDefaultCriterias());
        $this->presenter = null;
        $this->perPage = 30;
    }

    public function repository($repository)
    {
        $this->data = null;
        $this->repository = $repository;
        return $this;
    }

    public function fromCollection($data)
    {
        $this->repository = null;
        $this->data = $data;
        return $this;
    }

    public function presenter($presenter)
    {
        if (!$presenter instanceof Presenter) {
            throw new \Exception("The presenter passed as argument is not a instance of App\Base\Presenter", 1);
        }

        $this->presenter = $presenter;

        return $this;
    }

    public function criterias($criterias)
    {
        if ($criterias instanceof Collection) {
            $this->criterias->merge($criterias);
        } else {
            $this->criterias->merge(collect($criterias));
        }

        return $this;
    }

    public function perPage($perPage)
    {
        $this->per_page = $perPage;
        return $this;
    }

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

        $data = $this->repository->paginate($this->perPage)->items();
        $data = collect($data);

        $presented_data = $this->presenter->get($data);
        return $this->getPaginatedCollection($presented_data);
    }

    private function buildForDataCollection()
    {
        if ($this->presenter == null) {
            $data = $this->data;
        } else {
            $data = $this->presenter->get($this->data);
        }

        return $this->getPaginatedCollection($data);
    }

    private function getPaginatedCollection($items)
    {
        if (!$items instanceof Collection) {
            $items = collect($items);
        }

        $perPage = $this->perPage;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);

        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }

    private function getDefaultCriterias()
    {
        $default_criterias[] = new OrderResolvedByUrlCriteria();

        return $default_criterias;
    }
}
