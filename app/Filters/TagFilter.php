<?php

namespace App\Filters;

use EscuelaIT\APIKit\CustomFilter;
use Illuminate\Database\Eloquent\Builder;

class TagFilter extends CustomFilter
{
    /**
     * Name of the filter as expected in the querystring.
     * Example: filters[][name]=tag
     */
    protected $filterName = 'tag';

    /**
     * Apply the filter: constrain results to models that have the provided tag id(s).
     */
    public function apply(Builder $query): void
    {
        $value = $this->getFilterValue();

        if (null === $value || $value === '') {
            return;
        }

        if (is_array($value)) {
            $query->whereHas('tags', function (Builder $q) use ($value) {
                $q->whereIn('id', $value);
            });

            return;
        }

        $query->whereHas('tags', function (Builder $q) use ($value) {
            $q->where('id', $value);
        });
    }
}
