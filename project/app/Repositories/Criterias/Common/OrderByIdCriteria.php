<?php
namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;

class OrderByIdCriteria extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $queryBuilder = $queryBuilder->orderBy('id', 'desc');
        return $queryBuilder;
    }
}
