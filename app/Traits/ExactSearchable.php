<?php
namespace App\Traits;

trait ExactSearchable
{
    public function scopeExactSearch($query, array $terms)
    {
        foreach ($terms as $column => $value) {
            if ($value != null) {
                // Check if the column is a relationship using dot notation
                if (strpos($column, '.') !== false) {
                    // Split the string into the relationship name and the actual column
                    [$relation, $relationColumn] = explode('.', $column);

                    // Apply a condition on the relationship
                    $query->whereHas($relation, function ($q) use ($relationColumn, $value) {
                        $q->where($relationColumn, '=', $value);
                    });
                } else {
                    // Apply a condition on the current model
                    $query->where($column, '=', $value);
                }
            }
        }

        return $query;
    }
}
