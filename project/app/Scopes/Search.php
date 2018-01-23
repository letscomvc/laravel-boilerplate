<?php

namespace App\Scopes;

trait Search
{
    private function addConditionSensitive($query, $column, $search)
    {
        $query->orWhere($column, 'LIKE', "%$search%");
    }

    private function addConditionInsensitive($query, $column, $search)
    {
        $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", "%$search%");
    }

    private function addConditions($query, $search, $searchBy)
    {
        foreach ($searchBy as $key => $field) {
            $hasNoCase = is_numeric($key);
            if ($hasNoCase) {
                $this->addConditionInsensitive($query, $field, $search);
            } else {
                if ($field == 'sensitive') {
                    $this->addConditionSensitive($query, $key, $search);
                } elseif ($field == 'insensitive') {
                    $this->addConditionInsensitive($query, $key, $search);
                } else {
                    throw new InvalidArgumentException("Invalid search case");
                }
            }
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if (isset($this->searchBy)) {
            if (is_array($this->searchBy)) {
                $searchBy = $this->searchBy;
                $query->where(function ($query) use ($search, $searchBy) {
                    $this->addConditions($query, $search, $searchBy);
                });
            } else {
                $this->addConditionInsensitive($query, $this->searchBy, $search);
            }
        }
    }
}
