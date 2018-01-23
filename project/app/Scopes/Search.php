<?php

namespace App\Scopes;

trait Search
{
    private function addConditions($query, $search, $searchBy)
    {
        foreach ($searchBy as $field) {
            $query->orWhere($field, 'LIKE', "%$search%");
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if (isset($this->searchBy)) {
            if (is_array($this->searchBy)) {
                $searchBy = $this->searchBy;
                $query->where(function($query) use ($search, $searchBy) {
                    $this->addConditions($query, $search, $searchBy);
                });
            } else {
                $query->where($this->searchBy, 'LIKE', "%$search%");
            }
        }
    }
}
