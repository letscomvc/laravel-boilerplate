<?php
namespace App\Repositories\Criteria\Common;

use App\Repositories\Criteria\Criteria;
use App\Repositories\Repository;

class OrderResolvedByUrlCriteria extends Criteria
{
    private $defaultOrderBy;

    public function __construct($defaultOrderBy)
    {
        $this->defaultOrderBy = $defaultOrderBy;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        $field = \Request::input('field') ?? $this->defaultOrderBy['field'] ?? 'updated_at';
        $order = \Request::input('order') ?? $this->defaultOrderBy['order'] ?? 'desc';

        $queryBuilder = $queryBuilder->orderBy($field, $order);

        return $queryBuilder;
    }
}
