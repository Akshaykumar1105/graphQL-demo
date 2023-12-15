<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function __construct(private Category $categoryObj)
    {
        //
    }

    public function collection()
    {
        return $this->categoryObj->get();
    }
}
