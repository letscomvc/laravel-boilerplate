<?php
namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;

class OrderByIdCriteria extends Criteria
{
    public function apply($model, Repository $repository)
    {
        $query = $model->orderBy('id', 'desc');
        return $query;
    }
}
