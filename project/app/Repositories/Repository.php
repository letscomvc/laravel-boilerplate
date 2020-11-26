<?php
namespace App\Repositories;

use App\Exceptions\Repositories\RepositoryException;
use App\Repositories\Criteria\Criteria;
use App\Repositories\Criteria\CriteriaContract;
use App\Traits\Newable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Repository implements CriteriaContract
{
    use Newable;

    /**
     * @var
     */
    protected $model;

    /**
     * @var string
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
     * @param Collection $criteria
     * @throws RepositoryException
     */
    public function __construct()
    {
        $this->criteria = collect();
        $this->resetScope();
        $this->resetQuery();
    }

    abstract protected function getClass();

    protected function resetQuery()
    {
        $this->model = $this->makeModel();
    }

    protected function returnOrFindModel($element)
    {
        $class = $this->getClass();
        if ($element instanceof $class) {
            return $element;
        }

        if (is_numeric($element)) {
            return $this->model->findOrFail($element);
        }
    }

    protected function returnOrFindModelWithTrashed($element)
    {
        $class = $this->getClass();
        if ($element instanceof $class) {
            return $element;
        }

        if (is_numeric($element)) {
            return $this->model->withTrashed()->findOrFail($element);
        }
    }

    public function first()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->first();
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

    public function findOrNew($id, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->findOrNew($id);
    }

    public function firstOrCreate($data)
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->firstOrCreate($data);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        $query = $this->model->where($field, $value)
                             ->addSelect($columns);
        return $query;
    }

    public function whereIn(string $field, array $values, array $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        $query = $this->model
            ->whereIn($field, $values)
            ->addSelect($columns);
        return $query->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function activate($id)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModel($id);
        if ($model) {
            $model->is_active = true;
            $model->save();
            return $model;
        }

        throw new RepositoryException("Model not found.", 404);
    }

    public function deactivate($id)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModel($id);
        if ($model) {
            $model->is_active = false;
            $model->save();
            return $model;
        }

        throw new RepositoryException("Model not found.", 404);
    }

    public function delete($id)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModel($id);
        $model->delete();
        return $model;
    }

    public function deleteMultiple($ids)
    {
        $this->resetQuery();
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function restore($id)
    {
        $this->resetQuery();
        $trashedModel = $this->returnOrFindModelWithTrashed($id);

        if ($trashedModel->trashed()) {
            $trashedModel->restore();
        }

        return $trashedModel;
    }

    public function update($id, $data)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModel($id);
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
     * @param mixed $criteria
     * @return $this
     */
    public function pushCriteria($criteria)
    {
        if (is_array($criteria) || $criteria instanceof Collection) {
            foreach ($criteria as $eachCriteria) {
                $this->pushCriteria($eachCriteria);
            }
        } else {
            $this->criteria->push($criteria);
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

    /**
     * @return $this
     */
    public function toSql()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->toSql();
    }
}
