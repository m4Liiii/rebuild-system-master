<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $terms)
{
    $query->where(function ($q) use ($terms) {
        foreach ($terms as $termKey => $termValue) {
            if ($termValue) {
                $columns = explode('|', $termKey);
                $q->where(function ($subQuery) use ($columns, $termValue) {
                    foreach ($columns as $column) {
                        if (strpos($column, '.') != false) {
                            [$relation, $relationColumn] = explode('.', $column);
                            $subQuery->orWhereHas($relation, function ($relationQuery) use ($termValue, $relationColumn) {
                                $relationQuery->where($relationColumn, 'LIKE', '%' . $termValue . '%');
                            });
                        } else {
                            $subQuery->orWhere($column, 'LIKE', '%' . $termValue . '%');
                        }
                    }
                });
            }
        }
    });

    return $query;
}

}
