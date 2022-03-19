<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Image;
use App\Models\MainPageCategory;
use App\Models\Product;
use App\Observers\ImageObserver;
use App\Observers\MainPageCategoriesObserver;
use App\Observers\ProductsObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Image::observe(ImageObserver::class);
        MainPageCategory::observe(MainPageCategoriesObserver::class);
        Product::observe(ProductsObserver::class);
    }
}
