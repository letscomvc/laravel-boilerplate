<?php
namespace App\Repositories\Criteria;

use App\Repositories\Repository;

abstract class Criteria
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    abstract public function apply($model, Repository $repository);
}
