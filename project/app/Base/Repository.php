<?php
namespace App\Base;

use Illuminate\Support\Collection;
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
        $this->resetQuery();
    }

    abstract protected function getClass();

    private function resetQuery()
    {
        $this->model = $this->makeModel();
    }

    public function all($columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->select($columns)->get();
    }

    public function pluck($key, $value = null)
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->pluck($key, $value);
    }

    public function find($id, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->find($id);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        $query = $this->model->where($field, '=', $value)
                             ->addSelect($columns);
        return $query;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function activate($id)
    {
        $this->resetQuery();
        $model = $this->model->find($id);
        if ($model) {
            $model->is_active = true;
            return $model->save();
        }

        throw new RepositoryException("Model not found.", 404);
    }

    public function deactivate($id)
    {
        $this->resetQuery();
        $model = $this->model->findOrFail($id);
        $model->is_active = false;
        return $model->save();
    }

    public function delete($id)
    {
        $this->resetQuery();
        $model = $this->model->findOrFail($id);
        $model->delete();
        return $model;
    }

    public function update($id, $data)
    {
        $this->resetQuery();
        $model = $this->model->find($id);
        $model->update($data);

        return $model;
    }

    public function paginate($perPage = 15, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    public function count()
    {
        $this->resetQuery();
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
            $message = "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model";
            throw new RepositoryException($message);
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
     * @param mixed $criterias
     * @return $this
     */
    public function pushCriteria($criterias)
    {
        if (is_array($criterias) || $criterias instanceof Collection) {
            foreach ($criterias as $criteria) {
                $this->pushCriteria($criteria);
            }
        } else {
            $this->criteria->push($criterias);
        }

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
            } else {
                $class = get_class($criteria);
                $message = "Class {$class} must be an instance of App\\Base\\Criteria";
                throw new RepositoryException($message);
            }
        }

        return $this;
    }
}
