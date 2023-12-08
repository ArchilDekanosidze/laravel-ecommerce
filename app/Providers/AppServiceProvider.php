<?php

namespace App\Providers;

use App\Models\Notification;
use Laravel\Sanctum\Sanctum;
use App\Models\Content\Comment;
use App\Models\Market\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Services\Uploader\StorageManager;
use App\Services\Category\CategoryService;
use Illuminate\Contracts\Foundation\Application;
use App\Services\Category\Contracts\CategoryInterface;
use App\Services\Uploader\Image\ImageInterventionService;
use App\Services\Notification\Sms\Providers\FarazSms\FarazSms;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        view()->composer('admin.layouts.header', function ($view) {
            $view->with('unseenComments', Comment::where('seen', 0)->get());
            $view->with('notifications', Notification::where('read_at', null)->get());
        });

        view()->composer('customer.layouts.header', function ($view) {
            if (Auth::check()) {
                $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
                $view->with('cartItems', $cartItems);
            }
        });

        $this->app->bind(SmsSenderInterface::class, FarazSms::class);
        $this->app->bind(CategoryInterface::class, CategoryService::class);
        $this->app->bind(ImageServiceInterface::class, ImageInterventionService::class);


        // $this->app->bind(ImageServiceInterface::class, function (Application $app, $params) {
        //     return new ImageInterventionService(new StorageManager());
        // });
    }
}
