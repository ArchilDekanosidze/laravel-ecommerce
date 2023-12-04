<?php

namespace App\Providers;

use App\Models\Notification;
use Laravel\Sanctum\Sanctum;
use App\Models\Content\Comment;
use App\Models\Market\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Services\Notification\Sms\Contracts\SmsSender;
use App\Services\Notification\Sms\Providers\FarazSms\FarazSms;

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

        $this->app->bind(SmsSender::class, function (Application $app, $params) {
            return new FarazSms($params['phone_numbers'], $params['data']);
        });
    }
}
