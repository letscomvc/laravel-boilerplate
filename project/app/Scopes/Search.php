<?php

namespace App\Scopes;

trait Search
{
    private function addCondition($index, $field, $query, $search)
    {
        if ($index == 0) {
            $query->where($field, 'LIKE', "%$search%");
        } else {
            $query->orWhere($field, 'LIKE', "%$search%");
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($this->searchBy) {
            if (is_array($this->searchBy)) {
                foreach ($this->searchBy as $index => $field) {
                    $query = $this->addCondition($index, $field, $query, $search);
                }
            } else {
                return $query->where($this->searchBy, 'LIKE', "%$search%");
            }
        }
    }
}
