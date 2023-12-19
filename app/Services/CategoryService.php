<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function __construct(private Category $categoryObj)
    {
        //
    }

    public function collection($inputs)
    {
        return $this->categoryObj->select($inputs['select'])->get();
    }
}
