<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function __construct(private Category $categoryObj)
    {
        //
    }

    public function collection($args)
    {
        return $this->categoryObj->select($args['select'])->get();
    }
}
