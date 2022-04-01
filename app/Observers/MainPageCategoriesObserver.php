<?php

namespace App\Observers;

use App\Models\MainPageCategory;
use Illuminate\Support\Facades\Cache;

class MainPageCategoriesObserver
{
    /**
     * Handle the MainPageCategory "created" event.
     *
     * @param  \App\Models\MainPageCategory  $mainPageCategory
     * @return void
     */
    public function created(MainPageCategory $mainPageCategory)
    {
        Cache::forget('mainPageCategories');
    }

    /**
     * Handle the MainPageCategory "updated" event.
     *
     * @param  \App\Models\MainPageCategory  $mainPageCategory
     * @return void
     */
    public function updated(MainPageCategory $mainPageCategory)
    {
        Cache::forget('mainPageCategories');
    }

    /**
     * Handle the MainPageCategory "deleted" event.
     *
     * @param  \App\Models\MainPageCategory  $mainPageCategory
     * @return void
     */
    public function deleted(MainPageCategory $mainPageCategory)
    {
        Cache::forget('mainPageCategories');
    }

    /**
     * Handle the MainPageCategory "restored" event.
     *
     * @param  \App\Models\MainPageCategory  $mainPageCategory
     * @return void
     */
    public function restored(MainPageCategory $mainPageCategory)
    {
        //
    }

    /**
     * Handle the MainPageCategory "force deleted" event.
     *
     * @param  \App\Models\MainPageCategory  $mainPageCategory
     * @return void
     */
    public function forceDeleted(MainPageCategory $mainPageCategory)
    {
        //
    }
}
