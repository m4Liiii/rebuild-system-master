<?php

namespace App\Traits;

trait NumFilt
{
    /**
     * Apply a boolean filter to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNumFilt($query, $column, $value)
    {
        if ($value == 'greater') {
            $query->where($column, '>', 0);
        } elseif ($value == 'smaller') {
            $query->where($column, '<', 0);
        } elseif ($value == 'equal') {
            $query->where($column, '=', 0);
        }
        elseif ($value == 'greater_equal') {
            $query->where($column, '>=', 0);
        }
        elseif ($value == 'smaller_equal') {
            $query->where($column, '<=', 0);
        }

        return $query;
    }

}
