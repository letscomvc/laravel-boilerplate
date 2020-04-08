<?php
namespace App\Repositories\Criteria\Common;

use App\Repositories\Criteria\Criteria;
use App\Repositories\Repository;

class SearchResolvedByUrlCriteria extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $params = request()->all();
        if (!array_get($params, 'query')) {
            return $queryBuilder;
        }

        $query = $params['query'];

        $queryBuilder->search($query);

        return $queryBuilder;
    }
}
