<?php

namespace App\Traits;

use App\Models\PerPage;
use Illuminate\Support\Facades\Request;

trait Paginateable
{
    /**
     * Paginate the given query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|null  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopePaginateQuery($query, $perPage = null)
    {
        // Retrieve the 'numpage' field from the PerPage model
        $perPageSetting = PerPage::where('id', 1)->first();

        // Use the numpage value if available, otherwise use the provided $perPage or a default value
        $perPage = $perPageSetting ? $perPageSetting->numpage : ($perPage ?? 15);

        return $query->paginate($perPage);
    }

}
