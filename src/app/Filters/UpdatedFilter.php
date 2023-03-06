<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\DateFilter;

class UpdatedFilter extends DateFilter
{
    public $title =  "Publish date";

    /**
     * Modify the current query when the filter is used
     *
     * @param Builder $query Current query
     * @param Carbon $date Carbon instance with the date selected
     * @return Builder Query modified
     */
    public function apply(Builder $query, Carbon $date, $request): Builder
    {
        $query->where('pub_date','>=', $date->format('Y-m-d 00:00:00'));
        $query->where('pub_date','<=', $date->format('Y-m-d 23:59:59'));
        return $query;
    }
}
