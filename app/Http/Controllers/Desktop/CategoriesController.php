<?php

namespace App\Http\Controllers\Desktop;

use App\Models\ProductCategory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getAllCategories(Request $request)
    {
        $categories = ProductCategory::query();

        return $categories->orderBy('name')->get();
    }
}
