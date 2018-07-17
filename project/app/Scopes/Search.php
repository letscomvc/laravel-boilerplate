<?php

namespace App\Scopes;

trait Search
{
    private function addConditions($query, $search, $searchBy)
    {
        $searchBy = array_filter($searchBy);
        foreach ($searchBy as $key => $field) {
            $query->orWhereRaw("CAST({$field} as VARCHAR) ILIKE ?", "%$search%");
        }

        return $query;
    }

    private function addConditionsForRelationships($query, $search, $relationships)
    {
        $relationships = array_filter($relationships);
        foreach ($relationships as $relation => $fields) {
            $query->orWhereHas($relation, function ($query) use ($fields, $search) {
                $query->where(function ($query) use ($fields, $search) {
                    $this->addConditions($query, $search, $fields);
                });
            });
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if (method_exists(get_called_class(), 'setupSearch')) {
            $this->setupSearch();
        }

        $query->where(function ($query) use ($search) {
            if (isset($this->searchBy) && is_array($this->searchBy)) {
                $this->addConditions($query, $search, $this->searchBy);
            }

            if (isset($this->searchByRelationship) && is_array($this->searchByRelationship)) {
                $this->addConditionsForRelationships($query, $search, $this->searchByRelationship);
            }
        });
    }
}
