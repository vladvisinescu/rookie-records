<?php

namespace App\Observers;

use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategoryObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param ProductCategory $category
     * @return void
     */
    public function saving(ProductCategory $category)
    {
        $category->slug = Str::slug($category->name);
    }

    /**
     * Handle the ProductCategory "updated" event.
     *
     * @param ProductCategory $category
     * @return void
     */
    public function updated(ProductCategory $category)
    {
        //
    }

    /**
     * Handle the ProductCategory "deleted" event.
     *
     * @param ProductCategory $category
     * @return void
     */
    public function deleted(ProductCategory $category)
    {
        //
    }

    /**
     * Handle the ProductCategory "restored" event.
     *
     * @param ProductCategory $category
     * @return void
     */
    public function restored(ProductCategory $category)
    {
        //
    }

    /**
     * Handle the ProductCategory "force deleted" event.
     *
     * @param ProductCategory $category
     * @return void
     */
    public function forceDeleted(ProductCategory $category)
    {
        //
    }
}
