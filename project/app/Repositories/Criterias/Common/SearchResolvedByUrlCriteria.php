<?php
namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
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
