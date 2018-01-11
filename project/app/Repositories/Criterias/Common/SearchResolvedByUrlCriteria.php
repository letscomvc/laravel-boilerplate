<?php
namespace App\Repositories\Criterias\Common;

use Illuminate\Support\Facades\Input;

use App\Base\Criteria;
use App\Base\Repository;

class SearchResolvedByUrlCriteria extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $params = Input::all();
        if (!$params['query']) {
            return $queryBuilder;
        }

        $query = $params['query'];
        $queryBuilder->search($query);

        return $queryBuilder;
    }
}
