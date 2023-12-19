<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait FilterTrait
{
    public function filter($query, $filters)
    {
        if (!$filters) {
            return $query;
        }

        foreach ($filters as $key => $value) {
            $scopeFilter = Str::camel($key);

            if (! is_null($value)) {
                $query->$scopeFilter($value);
            }
        }

        return $query;
    }
}
