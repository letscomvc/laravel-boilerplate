<?php
namespace App\Repositories\Criterias\Common;

use Illuminate\Support\Facades\Input;

use App\Base\Criteria;
use App\Base\Repository;

class OrderResolvedByUrlCriteria extends Criteria
{
    public function apply($queryBuilder, Repository $repository)
    {
        $params = Input::all();
        if (!$params['field']) {
            $params['field'] = 'id';
        }

        if (!$params['order']) {
            $params['order'] = 'desc';
        }

        $queryBuilder = $queryBuilder->orderBy($params['field'], $params['order']);

        return $queryBuilder;
    }
}
