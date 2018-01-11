<?php
namespace App\Base;

use Illuminate\Database\Eloquent\Model;

use App\Base\Criteria;
use App\Contracts\Repositories\CriteriaContract;
use App\Exceptions\Repositories\RepositoryException;

abstract class Repository implements CriteriaContract
{

    /**
     * @var
     */
    protected $model;

    /**
     * @var class
     */
    protected $class;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @param Collection $criterias
     * @throws RepositoryException
     */
    public function __construct()
    {
        $this->criteria = collect();
        $this->resetScope();
        $this->model = $this->makeModel();
    }

    abstract protected function getClass();

    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->all();
    }

    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->find($id);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        $this->applyCriteria();
        $query = $this->model->where($field, '=', $value)
                             ->addSelect($columns);
        return $query;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->delete();

        return $model;
    }

    public function update($id, $data)
    {
        $model = $this->model->find($id);
        $model->update($data);

        return $model;
    }

    public function paginate($perPage = 15, $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    public function count()
    {
        $this->applyCriteria();
        return $this->model->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel($options = [])
    {
        $class = $this->getClass();
        $model = new $class($options);

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $model->newQuery();
    }


    /**
     * @return $this
     */
    public function resetScope()
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }
}
