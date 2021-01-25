<?php

namespace App\Scopes;

use Illuminate\Database\PostgresConnection;

trait Search
{
    public function scopeSearch(
        $query,
        string $term,
        ?array $searchBy = null,
        ?array $searchByRelationship = null
    ) {

        if ($searchBy !== null) {
            $this->searchBy = $searchBy;
        }

        if ($searchByRelationship !== null) {
            $this->searchByRelationship = $searchByRelationship;
        }

        $query->where(function ($query) use ($term) {
            if (isset($this->searchBy) && is_array($this->searchBy)) {
                $this->addConditions($query, $term, $this->searchBy);
            }

            if (isset($this->searchByRelationship) && is_array($this->searchByRelationship)) {
                $this->addConditionsForRelationships($query, $term, $this->searchByRelationship);
            }
        });

        return $query;
    }

    private function addConditions($query, $term, $searchBy)
    {
        $terms = str_getcsv($term, ' ', '"');
        collect($terms)
            ->filter()
            ->each(function ($term) use ($searchBy, $query) {
                foreach (array_filter($searchBy) as $key => $field) {
                    (!$query->getConnection() instanceof PostgresConnection)
                        ? $query->orWhereRaw("{$field} LIKE ?", "$term%")
                        : $query->orWhereRaw("CAST({$field} as VARCHAR) ILIKE ?", "$term%");
                }
            });

        return $query;
    }

    private function addConditionsForRelationships($query, $term, $relationships)
    {
        $relationships = array_filter($relationships);
        foreach ($relationships as $relation => $fields) {
            $query->orWhereHas($relation, function ($query) use ($fields, $term) {
                $query->where(function ($query) use ($fields, $term) {
                    $this->addConditions($query, $term, $fields);
                });
            });
        }

        return $query;
    }
}
