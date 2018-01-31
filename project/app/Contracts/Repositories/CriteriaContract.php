<?php
namespace App\Contracts\Repositories;

use App\Base\Criteria;

/**
 * Interface CriteriaInterface
 * @package Bosnadev\Repositories\Contracts
 */
interface CriteriaContract
{
    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * @return mixed
     */
    public function getCriteria();

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria);

    /**
     * @param mixed $criteria
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * @return $this
     */
    public function applyCriteria();
}
