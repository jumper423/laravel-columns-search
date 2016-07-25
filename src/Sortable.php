<?php

namespace jumper423\LaravelTrait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;

/**
 * Trait Sortable.
 */
trait Search
{
    protected $searchColumns = [];

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeSearch($query)
    {
        if (Input::has('q') && count($this->searchColumns)) {
            $q = Input::get('q');
            $searchColumns = $this->searchColumns;
            $query->where(function ($query2) use ($q, $searchColumns) {
                foreach ($searchColumns as $searchColumn) {
                    $query2->orWhere($searchColumn, 'ilike', "%{$q}%");
                }
            });
        }
        return $query;
    }
}
