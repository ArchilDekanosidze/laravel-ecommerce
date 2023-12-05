<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Content\BannerController;
use App\Http\Controllers\Admin\Content\CategoryController as ContentCategoryController;
use App\Http\Controllers\Admin\Content\CommentController as ContentCommentController;
use App\Http\Controllers\Admin\Content\FAQController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Market\BrandController;
use App\Http\Controllers\Admin\Market\CategoryController as MarketCategoryController;
use App\Http\Controllers\Admin\Market\CommentController as MarketCommentController;
use App\Http\Controllers\Admin\Market\DeliveryController;
use App\Http\Controllers\Admin\Market\DiscountController;
use App\Http\Controllers\Admin\Market\GalleryController;
use App\Http\Controllers\Admin\Market\GuaranteeController;
use App\Http\Controllers\Admin\Market\OrderController;
use App\Http\Controllers\Admin\Market\PaymentController;
use App\Http\Controllers\Admin\Market\ProductColorController;
use App\Http\Controllers\Admin\Market\ProductController;
use App\Http\Controllers\Admin\Market\PropertyController;
use App\Http\Controllers\Admin\Market\PropertyValueController;
use App\Http\Controllers\Admin\Market\StoreController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Notify\EmailController;
use App\Http\Controllers\Admin\Notify\EmailFileController;
use App\Http\Controllers\Admin\Notify\SMSController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Ticket\TicketAdminController;
use App\Http\Controllers\Admin\Ticket\TicketCategoryController;
use App\Http\Controllers\Admin\Ticket\TicketController;
use App\Http\Controllers\Admin\Ticket\TicketPriorityController;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Admin\User\CustomerController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OTP\ForgotPasswordOTPController;
use App\Http\Controllers\Auth\OTP\LoginOTPController;
use App\Http\Controllers\Auth\OTP\LoginTwoFactorController;
use App\Http\Controllers\Auth\OTP\Profile\ProfileEmailController;
use App\Http\Controllers\Auth\OTP\Profile\ProfileMobileController;
use App\Http\Controllers\Auth\OTP\Profile\ProfileTwoFactorController;
use App\Http\Controllers\Auth\OTP\RegisterOTPController;
use App\Http\Controllers\Auth\OTP\ResetPasswordOTPController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\Market\ProductController as MarketProductController;
use App\Http\Controllers\Customer\Profile\AddressController as ProfileAddressController;
use App\Http\Controllers\Customer\Profile\CompareController;
use App\Http\Controllers\Customer\Profile\FavoriteController;
use App\Http\Controllers\Customer\Profile\OrderController as ProfileOrderController;
use App\Http\Controllers\Customer\Profile\ProfileController;
use App\Http\Controllers\Customer\Profile\TicketController as ProfileTicketController;
use App\Http\Controllers\Customer\SalesProcess\AddressController;
use App\Http\Controllers\Customer\SalesProcess\CartController;
use App\Http\Controllers\Customer\SalesProcess\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\SalesProcess\ProfileCompletionController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
 */

Route::prefix('auth')->name('auth.')->middleware('throttle:Medium')->group(function () {
    Route::get('/login', [LoginController::class, 'ShowloginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('otp/login/two-factor/code', [LoginTwoFactorController::class, 'showEnterCodeForm'])->name('otp.login.two.factor.code.form');
    Route::post('otp/login/two-factor/code', [LoginTwoFactorController::class, 'confirmCode'])->name('otp.login.two.factor.code');
    Route::get('otp/login/two-factor/resend', [LoginTwoFactorController::class, 'resend'])->name('otp.login.two.factor.resend');
    Route::get('otp/login', [LoginOTPController::class, 'showOTPForm'])->name('otp.login.form');
    Route::post('otp/login', [LoginOTPController::class, 'sendToken'])->name('otp.login.send.token');
    Route::get('otp/login/code', [LoginOTPController::class, 'showEnterCodeForm'])->name('otp.login.code.form');
    Route::post('otp/login/code', [LoginOTPController::class, 'confirmCode'])->name('otp.login.code');
    Route::get('otp/login/resend', [LoginOTPController::class, 'resend'])->name('otp.login.resend');
    Route::get('register', [RegisterController::class, 'ShowRegisterationForm'])->name('register.form');
    Route::post('register', [RegisterController::class, 'Register'])->name('register');
    Route::get('otp/register', [RegisterOTPController::class, 'showOTPForm'])->name('otp.register.form');
    Route::post('otp/register', [RegisterOTPController::class, 'sendToken'])->name('otp.register.send.token');
    Route::get('otp/register/code', [RegisterOTPController::class, 'showEnterCodeForm'])->name('otp.register.code.form');
    Route::post('otp/register/code', [RegisterOTPController::class, 'confirmCode'])->name('otp.register.code');
    Route::get('otp/register/resend', [RegisterOTPController::class, 'resend'])->name('otp.register.resend');
    Route::get('redirect/{provider}', [SocialController::class, 'RredirectToProvider'])->name('login.provider.redirect');
    Route::get('{provider}/callback', [SocialController::class, 'providerCallback'])->name('login.provider.callback');
    Route::get('password/forget', [ForgotPasswordController::class, 'showForgetForm'])->name('password.forget.form');
    Route::post('password/forget', [ForgotPasswordController::class, 'sendResetLink'])->name('password.forget');
    Route::get('otp/password/forget', [ForgotPasswordOTPController::class, 'showOTPForm'])->name('otp.password.forget.form');
    Route::post('otp/password/forget', [ForgotPasswordOTPController::class, 'sendToken'])->name('otp.password.send.token');
    Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
    Route::get('otp/password/reset', [ResetPasswordOTPController::class, 'showEnterCodeForm'])->name('otp.password.code.form');
    Route::post('otp/password/reset', [ResetPasswordOTPController::class, 'confirmCode'])->name('otp.password.code');
    Route::get('otp/password/resend', [ResetPasswordOTPController::class, 'resend'])->name('otp.password.resend');
    Route::get('email/send-verification', [VerificationController::class, 'send'])->name('email.send.verification');
    Route::get('email/verify', [VerificationController::class, 'verify'])->name('email.verify');
    Route::get('otp/profile/two-factor/toggle', [ProfileTwoFactorController::class, 'showToggleForm'])->name('otp.profile.two.factor.toggle.form');
    Route::get('otp/profile/two-factor/activateByEmail', [ProfileTwoFactorController::class, 'sendTokenForEmail'])->name('otp.profile.two.factor.sendTokenForEmail');
    Route::get('otp/profile/two-factor/activateByMobile', [ProfileTwoFactorController::class, 'sendTokenForMobile'])->name('otp.profile.two.factor.sendTokenForMobile');
    Route::get('otp/profile/two-factor/code', [ProfileTwoFactorController::class, 'showEnterCodeForm'])->name('otp.profile.two.factor.code.form');
    Route::post('otp/profile/two-factor/code', [ProfileTwoFactorController::class, 'confirmCode'])->name('otp.profile.two.factor.code');
    Route::get('otp/profile/two-factor/resend', [ProfileTwoFactorController::class, 'resend'])->name('otp.profile.two.factor.resend');
    Route::get('otp/profile/two-factor/deactivate', [ProfileTwoFactorController::class, 'deactivate'])->name('otp.profile.two.factor.deactivate');
    Route::get('otp/profile/mobile', [ProfileMobileController::class, 'showOTPForm'])->name('otp.profile.mobile.form');
    Route::post('otp/profile/mobile', [ProfileMobileController::class, 'add'])->name('otp.profile.mobile');
    Route::get('otp/profile/mobile/code', [ProfileMobileController::class, 'showEnterCodeForm'])->name('otp.profile.mobile.code.form');
    Route::post('otp/profile/mobile/code', [ProfileMobileController::class, 'confirmCode'])->name('otp.profile.mobile.code');
    Route::get('otp/profile/mobile/resend', [ProfileMobileController::class, 'resend'])->name('otp.profile.mobile.resend');
    Route::get('otp/profile/email', [ProfileEmailController::class, 'showOTPForm'])->name('otp.profile.email.form');
    Route::post('otp/profile/email', [ProfileEmailController::class, 'add'])->name('otp.profile.email');
    Route::get('otp/profile/email/code', [ProfileEmailController::class, 'showEnterCodeForm'])->name('otp.profile.email.code.form');
    Route::post('otp/profile/email/code', [ProfileEmailController::class, 'confirmCode'])->name('otp.profile.email.code');
    Route::get('otp/profile/email/resend', [ProfileEmailController::class, 'resend'])->name('otp.profile.email.resend');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
 */

Route::prefix('admin')->name('admin.')->middleware('is.admin')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('home');

    Route::prefix('market')->name('market.')->group(function () {
        //category
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [MarketCategoryController::class, 'index'])->name('index');
            Route::get('/create', [MarketCategoryController::class, 'create'])->name('create');
            Route::post('/store', [MarketCategoryController::class, 'store'])->name('store');
            Route::get('/edit/{productCategory}', [MarketCategoryController::class, 'edit'])->name('edit');
            Route::put('/update/{productCategory}', [MarketCategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{productCategory}', [MarketCategoryController::class, 'destroy'])->name('destroy');
        });

        //brand
        Route::prefix('brands')->name('brands.')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
            Route::get('/create', [BrandController::class, 'create'])->name('create');
            Route::post('/store', [BrandController::class, 'store'])->name('store');
            Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('edit');
            Route::put('/update/{brand}', [BrandController::class, 'update'])->name('update');
            Route::delete('/destroy/{brand}', [BrandController::class, 'destroy'])->name('destroy');
        });

        //comment
        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/', [MarketCommentController::class, 'index'])->name('index');
            Route::get('/show/{comment}', [MarketCommentController::class, 'show'])->name('show');
            Route::post('/store', [MarketCommentController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MarketCommentController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [MarketCommentController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MarketCommentController::class, 'destroy'])->name('destroy');
            Route::get('/approved/{comment}', [MarketCommentController::class, 'approved'])->name('approved');
            Route::get('/status/{comment}', [MarketCommentController::class, 'status'])->name('status');
            Route::post('/answer/{comment}', [MarketCommentController::class, 'answer'])->name('answer');
        });

        //delivery
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('index');
            Route::get('/create', [DeliveryController::class, 'create'])->name('create');
            Route::post('/store', [DeliveryController::class, 'store'])->name('store');
            Route::get('/edit/{delivery}', [DeliveryController::class, 'edit'])->name('edit');
            Route::put('/update/{delivery}', [DeliveryController::class, 'update'])->name('update');
            Route::delete('/destroy/{delivery}', [DeliveryController::class, 'destroy'])->name('destroy');
            Route::get('/status/{delivery}', [DeliveryController::class, 'status'])->name('status');
        });

        //discount
        Route::prefix('discounts')->name('discounts.')->group(function () {
            Route::get('/copan', [DiscountController::class, 'copan'])->name('copan');
            Route::get('/copan/create', [DiscountController::class, 'copanCreate'])->name('copan.create');
            Route::get('/common-discount', [DiscountController::class, 'commonDiscount'])->name('commonDiscount');
            Route::post('/common-discount/store', [DiscountController::class, 'commonDiscountStore'])->name('commonDiscount.store');
            Route::get('/common-discount/edit/{commonDiscount}', [DiscountController::class, 'commonDiscountEdit'])->name('commonDiscount.edit');
            Route::put('/common-discount/update/{commonDiscount}', [DiscountController::class, 'commonDiscountUpdate'])->name('commonDiscount.update');
            Route::delete('/common-discount/destroy/{commonDiscount}', [DiscountController::class, 'commonDiscountDestroy'])->name('commonDiscount.destroy');
            Route::get('/common-discount/create', [DiscountController::class, 'commonDiscountCreate'])->name('commonDiscount.create');
            Route::get('/amazing-sale', [DiscountController::class, 'amazingSale'])->name('amazingSale');
            Route::get('/amazing-sale/create', [DiscountController::class, 'amazingSaleCreate'])->name('amazingSale.create');
            Route::post('/amazing-sale/store', [DiscountController::class, 'amazingSaleStore'])->name('amazingSale.store');
            Route::get('/amazing-sale/edit/{amazingSale}', [DiscountController::class, 'amazingSaleEdit'])->name('amazingSale.edit');
            Route::put('/amazing-sale/update/{amazingSale}', [DiscountController::class, 'amazingSaleUpdate'])->name('amazingSale.update');
            Route::delete('/amazing-sale/destroy/{amazingSale}', [DiscountController::class, 'amazingSaleDestroy'])->name('amazingSale.destroy');
            Route::post('/copan/store', [DiscountController::class, 'copanStore'])->name('copan.store');
            Route::get('/copan/edit/{copan}', [DiscountController::class, 'copanEdit'])->name('copan.edit');
            Route::put('/copan/update/{copan}', [DiscountController::class, 'copanUpdate'])->name('copan.update');
            Route::delete('/copan/destroy/{copan}', [DiscountController::class, 'copanDestroy'])->name('copan.destroy');
        });

        //order
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'all'])->name('all');
            Route::get('/new-order', [OrderController::class, 'newOrders'])->name('newOrders');
            Route::get('/sending', [OrderController::class, 'sending'])->name('sending');
            Route::get('/unpaid', [OrderController::class, 'unpaid'])->name('unpaid');
            Route::get('/canceled', [OrderController::class, 'canceled'])->name('canceled');
            Route::get('/returned', [OrderController::class, 'returned'])->name('returned');
            Route::get('/show/{order}', [OrderController::class, 'show'])->name('show');
            Route::get('/show/{order}/detail', [OrderController::class, 'detail'])->name('show.detail');
            Route::get('/change-send-status/{order}', [OrderController::class, 'changeSendStatus'])->name('changeSendStatus');
            Route::get('/change-order-status/{order}', [OrderController::class, 'changeOrderStatus'])->name('changeOrderStatus');
            Route::get('/cancel-order/{order}', [OrderController::class, 'cancelOrder'])->name('cancelOrder');
        });

        //payment
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/online', [PaymentController::class, 'online'])->name('online');
            Route::get('/offline', [PaymentController::class, 'offline'])->name('offline');
            Route::get('/cash', [PaymentController::class, 'cash'])->name('cash');
            Route::get('/canceled/{payment}', [PaymentController::class, 'canceled'])->name('canceled');
            Route::get('/returned/{payment}', [PaymentController::class, 'returned'])->name('returned');
            Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('show');
        });

        //product
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::put('/update/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');

            //gallery
            Route::prefix('galleries')->name('galleries.')->group(function () {
                Route::get('/{product}', [GalleryController::class, 'index'])->name('index');
                Route::get('/create/{product}', [GalleryController::class, 'create'])->name('create');
                Route::post('/store/{product}', [GalleryController::class, 'store'])->name('store');
                Route::delete('/destroy/{product}/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
            });

            //color
            Route::prefix('colors')->name('colors.')->group(function () {
                Route::get('/{product}', [ProductColorController::class, 'index'])->name('index');
                Route::get('/create/{product}', [ProductColorController::class, 'create'])->name('create');
                Route::post('/store/{product}', [ProductColorController::class, 'store'])->name('store');
                Route::delete('/destroy/{product}/{color}', [ProductColorController::class, 'destroy'])->name('destroy');
            });

            //guarantee
            Route::prefix('guarantees')->name('guarantees.')->group(function () {
                Route::get('/guarantee/{product}', [GuaranteeController::class, 'index'])->name('index');
                Route::get('/guarantee/create/{product}', [GuaranteeController::class, 'create'])->name('create');
                Route::post('/guarantee/store/{product}', [GuaranteeController::class, 'store'])->name('store');
                Route::delete('/guarantee/destroy/{product}/{guarantee}', [GuaranteeController::class, 'destroy'])->name('destroy');
            });
        });

        //property
        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [PropertyController::class, 'index'])->name('index');
            Route::get('/create', [PropertyController::class, 'create'])->name('create');
            Route::post('/store', [PropertyController::class, 'store'])->name('store');
            Route::get('/edit/{categoryAttribute}', [PropertyController::class, 'edit'])->name('edit');
            Route::put('/update/{categoryAttribute}', [PropertyController::class, 'update'])->name('update');
            Route::delete('/destroy/{categoryAttribute}', [PropertyController::class, 'destroy'])->name('destroy');

            //value
            Route::prefix('values')->name('values.')->group(function () {
                Route::get('/{categoryAttribute}', [PropertyValueController::class, 'index'])->name('index');
                Route::get('/create/{categoryAttribute}', [PropertyValueController::class, 'create'])->name('create');
                Route::post('/store/{categoryAttribute}', [PropertyValueController::class, 'store'])->name('store');
                Route::get('/edit/{categoryAttribute}/{value}', [PropertyValueController::class, 'edit'])->name('edit');
                Route::put('/update/{categoryAttribute}/{value}', [PropertyValueController::class, 'update'])->name('update');
                Route::delete('/destroy/{categoryAttribute}/{value}', [PropertyValueController::class, 'destroy'])->name('destroy');
            });
        });

        //store
        Route::prefix('stores')->name('stores.')->group(function () {
            Route::get('/', [StoreController::class, 'index'])->name('index');
            Route::get('/add-to-store/{product}', [StoreController::class, 'addToStore'])->name('add-to-store');
            Route::post('/store/{product}', [StoreController::class, 'store'])->name('store');
            Route::get('/edit/{product}', [StoreController::class, 'edit'])->name('edit');
            Route::put('/update/{product}', [StoreController::class, 'update'])->name('update');
        });
    });

    Route::prefix('content')->name('content.')->group(function () {
        //category
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [ContentCategoryController::class, 'index'])->name('index');
            Route::get('/create', [ContentCategoryController::class, 'create'])->name('create');
            Route::post('/store', [ContentCategoryController::class, 'store'])->name('store');
            Route::get('/edit/{postCategory}', [ContentCategoryController::class, 'edit'])->name('edit');
            Route::put('/update/{postCategory}', [ContentCategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{postCategory}', [ContentCategoryController::class, 'destroy'])->name('destroy');
            Route::get('/status/{postCategory}', [ContentCategoryController::class, 'status'])->name('status');
        });

        //comment
        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/', [ContentCommentController::class, 'index'])->name('index');
            Route::get('/show/{comment}', [ContentCommentController::class, 'show'])->name('show');
            Route::delete('/destroy/{comment}', [ContentCommentController::class, 'destroy'])->name('destroy');
            Route::get('/status/{comment}', [ContentCommentController::class, 'status'])->name('status');
            Route::get('/approved/{comment}', [ContentCommentController::class, 'approved'])->name('approved');
            Route::post('/answer/{comment}', [ContentCommentController::class, 'answer'])->name('answer');
        });

        //faq
        Route::prefix('faqs')->name('faqs.')->group(function () {
            Route::get('/', [FAQController::class, 'index'])->name('index');
            Route::get('/create', [FAQController::class, 'create'])->name('create');
            Route::post('/store', [FAQController::class, 'store'])->name('store');
            Route::get('/edit/{faq}', [FAQController::class, 'edit'])->name('edit');
            Route::put('/update/{faq}', [FAQController::class, 'update'])->name('update');
            Route::delete('/destroy/{faq}', [FAQController::class, 'destroy'])->name('destroy');
            Route::get('/status/{faq}', [FAQController::class, 'status'])->name('status');
        });

        //menu
        Route::prefix('menus')->name('menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('edit');
            Route::put('/update/{menu}', [MenuController::class, 'update'])->name('update');
            Route::delete('/destroy/{menu}', [MenuController::class, 'destroy'])->name('destroy');
            Route::get('/status/{menu}', [MenuController::class, 'status'])->name('status');
        });

        //page
        Route::prefix('pages')->name('pages.')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('index');
            Route::get('/create', [PageController::class, 'create'])->name('create');
            Route::post('/store', [PageController::class, 'store'])->name('store');
            Route::get('/edit/{page}', [PageController::class, 'edit'])->name('edit');
            Route::put('/update/{page}', [PageController::class, 'update'])->name('update');
            Route::delete('/destroy/{page}', [PageController::class, 'destroy'])->name('destroy');
            Route::get('/status/{page}', [PageController::class, 'status'])->name('status');
        });

        //post
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::post('/store', [PostController::class, 'store'])->name('store');
            Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit');
            Route::put('/update/{post}', [PostController::class, 'update'])->name('update');
            Route::delete('/destroy/{post}', [PostController::class, 'destroy'])->name('destroy');
            Route::get('/status/{post}', [PostController::class, 'status'])->name('status');
            Route::get('/commentable/{post}', [PostController::class, 'commentable'])->name('commentable');
        });

        //banner
        Route::prefix('banner')->name('banners.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('/create', [BannerController::class, 'create'])->name('create');
            Route::post('/store', [BannerController::class, 'store'])->name('store');
            Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('edit');
            Route::put('/update/{banner}', [BannerController::class, 'update'])->name('update');
            Route::delete('/destroy/{banner}', [BannerController::class, 'destroy'])->name('destroy');
            Route::get('/status/{banner}', [BannerController::class, 'status'])->name('status');
        });
    });

    Route::prefix('user')->name('user.')->group(function () {
        //admin-user
        Route::prefix('admin-users')->name('admin-users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/store', [AdminUserController::class, 'store'])->name('store');
            Route::get('/edit/{admin}', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/update/{admin}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/destroy/{admin}', [AdminUserController::class, 'destroy'])->name('destroy');
            Route::get('/status/{user}', [AdminUserController::class, 'status'])->name('status');
            Route::get('/activation/{user}', [AdminUserController::class, 'activation'])->name('activation');
            Route::get('/roles/{admin}', [AdminUserController::class, 'roles'])->name('roles.edit');
            Route::post('/roles/{admin}/store', [AdminUserController::class, 'rolesStore'])->name('roles.store');
            Route::get('/permissions/{admin}', [AdminUserController::class, 'permissions'])->name('permissions.edit');
            Route::post('/permissions/{admin}/store', [AdminUserController::class, 'permissionsStore'])->name('permissions.store');
        });

        //customer
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/store', [CustomerController::class, 'store'])->name('store');
            Route::get('/edit/{user}', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/update/{user}', [CustomerController::class, 'update'])->name('update');
            Route::delete('/destroy/{user}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('/status/{user}', [CustomerController::class, 'status'])->name('status');
            Route::get('/activation/{user}', [CustomerController::class, 'activation'])->name('activation');
        });

        //role
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/store', [RoleController::class, 'store'])->name('store');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('edit');
            Route::put('/update/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('permission-form');
            Route::put('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('permission-update');
        });

        //permission
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/create', [PermissionController::class, 'create'])->name('create');
            Route::post('/store', [PermissionController::class, 'store'])->name('store');
            Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('edit');
            Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('notify')->name('notify.')->group(function () {
        //email
        Route::prefix('emails')->name('emails.')->group(function () {
            Route::get('/', [EmailController::class, 'index'])->name('index');
            Route::get('/create', [EmailController::class, 'create'])->name('create');
            Route::post('/store', [EmailController::class, 'store'])->name('store');
            Route::get('/edit/{email}', [EmailController::class, 'edit'])->name('edit');
            Route::put('/update/{email}', [EmailController::class, 'update'])->name('update');
            Route::delete('/destroy/{email}', [EmailController::class, 'destroy'])->name('destroy');
            Route::get('/status/{email}', [EmailController::class, 'status'])->name('status');
            Route::get('/send-mail/{email}', [EmailController::class, 'sendMail'])->name('send-mail');
        });

        //email-file
        Route::prefix('email-files')->name('email-files.')->group(function () {
            Route::get('/{email}', [EmailFileController::class, 'index'])->name('index');
            Route::get('/{email}/create', [EmailFileController::class, 'create'])->name('create');
            Route::post('/{email}/store', [EmailFileController::class, 'store'])->name('store');
            Route::get('/edit/{file}', [EmailFileController::class, 'edit'])->name('edit');
            Route::put('/update/{file}', [EmailFileController::class, 'update'])->name('update');
            Route::delete('/destroy/{file}', [EmailFileController::class, 'destroy'])->name('destroy');
            Route::get('/status/{file}', [EmailFileController::class, 'status'])->name('status');
        });
        //sms
        Route::prefix('smss')->name('smss.')->group(function () {
            Route::get('/', [SMSController::class, 'index'])->name('index');
            Route::get('/create', [SMSController::class, 'create'])->name('create');
            Route::post('/store', [SMSController::class, 'store'])->name('store');
            Route::get('/edit/{sms}', [SMSController::class, 'edit'])->name('edit');
            Route::put('/update/{sms}', [SMSController::class, 'update'])->name('update');
            Route::delete('/destroy/{sms}', [SMSController::class, 'destroy'])->name('destroy');
            Route::get('/status/{sms}', [SMSController::class, 'status'])->name('status');
        });
    });

    Route::prefix('ticket')->name('ticket.')->group(function () {
        //main
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/show/{ticket}', [TicketController::class, 'show'])->name('show');
        Route::get('/new-tickets', [TicketController::class, 'newTickets'])->name('newTickets');
        Route::get('/open-tickets', [TicketController::class, 'openTickets'])->name('openTickets');
        Route::get('/close-tickets', [TicketController::class, 'closeTickets'])->name('closeTickets');
        Route::post('/answer/{ticket}', [TicketController::class, 'answer'])->name('answer');
        Route::get('/change/{ticket}', [TicketController::class, 'change'])->name('change');

        //category
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [TicketCategoryController::class, 'index'])->name('index');
            Route::get('/create', [TicketCategoryController::class, 'create'])->name('create');
            Route::post('/store', [TicketCategoryController::class, 'store'])->name('store');
            Route::get('/edit/{ticketCategory}', [TicketCategoryController::class, 'edit'])->name('edit');
            Route::put('/update/{ticketCategory}', [TicketCategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{ticketCategory}', [TicketCategoryController::class, 'destroy'])->name('destroy');
            Route::get('/status/{ticketCategory}', [TicketCategoryController::class, 'status'])->name('status');
        });

        //priority
        Route::prefix('priorities')->name('priorities.')->group(function () {
            Route::get('/', [TicketPriorityController::class, 'index'])->name('index');
            Route::get('/create', [TicketPriorityController::class, 'create'])->name('create');
            Route::post('/store', [TicketPriorityController::class, 'store'])->name('store');
            Route::get('/edit/{ticketPriority}', [TicketPriorityController::class, 'edit'])->name('edit');
            Route::put('/update/{ticketPriority}', [TicketPriorityController::class, 'update'])->name('update');
            Route::delete('/destroy/{ticketPriority}', [TicketPriorityController::class, 'destroy'])->name('destroy');
            Route::get('/status/{ticketPriority}', [TicketPriorityController::class, 'status'])->name('status');
        });

        //admin
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', [TicketAdminController::class, 'index'])->name('index');
            Route::get('/set/{admin}', [TicketAdminController::class, 'set'])->name('set');
        });
    });

    Route::prefix('setting')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/edit/{setting}', [SettingController::class, 'edit'])->name('edit');
        Route::put('/update/{setting}', [SettingController::class, 'update'])->name('update');
        Route::delete('/destroy/{setting}', [SettingController::class, 'destroy'])->name('destroy');
    });
    Route::post('/notification/read-all', [NotificationController::class, 'readAll'])->name('notification.readAll');
});

Route::get('/', [HomeController::class, 'home'])->name('customer.home');
Route::get('/products/{category?}', [HomeController::class, 'products'])->name('customer.products');
Route::get('/page/{page:slug}', [HomeController::class, 'page'])->name('customer.page');
Route::name('customer.')->group(function () {
    Route::name('sales-process.')->group(function () {

        //cart
        Route::name('carts.')->group(function () {
            Route::get('/cart', [CartController::class, 'cart'])->name('cart');
            Route::post('/cart', [CartController::class, 'updateCart'])->name('update-cart');
            Route::post('/add-to-cart/{product:slug}', [CartController::class, 'addToCart'])->name('add-to-cart');
            Route::get('/remove-from-cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('remove-from-cart');
        });

        //profile completion
        Route::name('profile-completions.')->group(function () {
            Route::get('/profile-completion', [ProfileCompletionController::class, 'profileCompletion'])->name('profile-completion');
            Route::post('/profile-completion', [ProfileCompletionController::class, 'update'])->name('profile-completion-update');
        });
        Route::middleware('profile.completion')->group(function () {
            //address
            Route::name('addresss.')->group(function () {
                Route::get('/address-and-delivery', [AddressController::class, 'addressAndDelivery'])->name('address-and-delivery');
                Route::post('/add-address', [AddressController::class, 'addAddress'])->name('add-address');
                Route::put('/update-address/{address}', [AddressController::class, 'updateAddress'])->name('update-address');
                Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('get-cities');
                Route::post('/choose-address-and-delivery', [AddressController::class, 'chooseAddressAndDelivery'])->name('choose-address-and-delivery');
            });

            //payment
            Route::name('payments.')->group(function () {
                Route::get('/payment', [CustomerPaymentController::class, 'payment'])->name('payment');
                Route::post('/copan-discount', [CustomerPaymentController::class, 'copanDiscount'])->name('copan-discount');
                Route::post('/payment-submit', [CustomerPaymentController::class, 'paymentSubmit'])->name('payment-submit');
                Route::any('/payment-callback/{order}/{onlinePayment}', [CustomerPaymentController::class, 'paymentCallback'])->name('payment-call-back');
            });
        });
    });

    Route::name('markets.')->group(function () {

        Route::get('/product/{product:slug}', [MarketProductController::class, 'product'])->name('product');
        Route::post('/add-comment/prodcut/{product:slug}', [MarketProductController::class, 'addComment'])->name('add-comment');
        Route::get('/add-to-favorite/prodcut/{product:slug}', [MarketProductController::class, 'addToFavorite'])->name('add-to-favorite');
        Route::get('/add-to-compare/prodcut/{product:slug}', [MarketProductController::class, 'addToCompare'])->name('add-to-compare');
        Route::post('/add-rate/prodcut/{product:slug}', [MarketProductController::class, 'addRate'])->name('add-rate');
    });

    Route::name('profiles.')->group(function () {

        Route::get('/orders', [ProfileOrderController::class, 'index'])->name('orders');
        Route::get('/my-favorites', [FavoriteController::class, 'index'])->name('my-favorites');
        Route::get('/my-favorites/delete/{product}', [FavoriteController::class, 'delete'])->name('my-favorites.delete');
        Route::get('/my-compares', [CompareController::class, 'index'])->name('my-compares');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/my-addresses', [ProfileAddressController::class, 'index'])->name('my-addresses');

        Route::prefix('my-tickets')->name('my-tickets.')->group(function () {
            Route::get('/', [ProfileTicketController::class, 'index'])->name('index');
            Route::get('/show/{ticket}', [ProfileTicketController::class, 'show'])->name('show');
            Route::post('/answer/{ticket}', [ProfileTicketController::class, 'answer'])->name('answer');
            Route::get('/change/{ticket}', [ProfileTicketController::class, 'change'])->name('change');
            Route::get('/create', [ProfileTicketController::class, 'create'])->name('create');
            Route::post('/store', [ProfileTicketController::class, 'store'])->name('store');
            // Route::post('/dowload/{file_name}', [ProfileTicketController::class, 'store'])->name('store');
        });
    });
});

Route::get('/testEmail', [TestController::class, 'testEmail']);
Route::get('/testSms', [TestController::class, 'testSms']);
Route::get('/tlogout', [TestController::class, 'tlogout']);
Route::get('/tredis/{id}', [TestController::class, 'tredis']);
Route::get('/tMongo', [TestController::class, 'tMongo']);
