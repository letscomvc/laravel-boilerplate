<?php
namespace App\Base;

use App\Base\Repository;

abstract class Criteria
{

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    abstract public function apply($model, Repository $repository);
}
