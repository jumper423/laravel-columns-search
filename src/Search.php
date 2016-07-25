<?php

namespace jumper423\LaravelTrait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;

/**
 * Trait Sortable.
 */
trait Search
{
    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeSearch($query)
    {
        if (Input::has('q') && count($this->searchColumns)) {
            $q = Input::get('q');
            $model = $this;
            $query->where(function ($query2) use ($q, $model) {
                foreach ($model->getColumns() as $searchColumn) {
                    switch (Schema::getColumnType($model->getTable(), $searchColumn)) {
                        case 'integer':
                        case 'bigint':
                        case 'smallint':
                        case 'float':
                            if (is_numeric($q)) {
                                $query2->orWhere($searchColumn, '=', (int)$q);
                            }
                            break;
                        case 'string':
                        case 'text':
                            $query2->orWhere($searchColumn, 'ilike', "%{$q}%");
                            break;
                    }

                }
            });
        }
        return $query;
    }

    /**
     * @return array
     */
    private function getColumns()
    {
        if (!isset($this->searchColumns)) {
            return [];
        } else {
            return $this->searchColumns;
        }
    }
}
