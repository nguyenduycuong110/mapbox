<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Controllers\Backend\User\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\Backend\User\UserCatalogueController;
use App\Http\Controllers\Backend\User\PermissionController;
use App\Http\Controllers\Backend\CodeController;
use App\Http\Controllers\Backend\Customer\CustomerController;
use App\Http\Controllers\Backend\Customer\CustomerCatalogueController;
use App\Http\Controllers\Backend\Post\PostCatalogueController;
use App\Http\Controllers\Backend\Post\PostController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\SlideController;
use App\Http\Controllers\Backend\WidgetController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\HomeStayController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Ajax\MenuController as AjaxMenuController;
use App\Http\Controllers\Ajax\SlideController as AjaxSlideController;
use App\Http\Controllers\Ajax\PostController as AjaxPostController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RouterController;
use App\Http\Controllers\Frontend\AuthController as FeAuthController;
use App\Http\Controllers\Frontend\CustomerController as FeCustomerController;
use App\Http\Controllers\Ajax\Frontend\AuthController as AjaxAuthController;
use App\Http\Controllers\Ajax\NotificationController as AjaxNotificationController;



//@@useController@@

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
/* FRONTEND ROUTES  */
Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('tim-kiem'.config('apps.general.suffix'), [FeProductCatalogueController::class, 'search'])->name('product.catalogue.search');

Route::get('lien-he'.config('apps.general.suffix'), [FeContactController::class, 'index'])->name('fe.contact.index');


/* CUSTOMER  */

Route::get('customer/login'.config('apps.general.suffix'), [FeAuthController::class, 'index'])->name('fe.auth.login')->middleware('check_login'); 

Route::get('customer/check/login'.config('apps.general.suffix'), [FeAuthController::class, 'login'])->name('fe.auth.dologin');

Route::get('customer/password/forgot'.config('apps.general.suffix'), [FeAuthController::class, 'forgotCustomerPassword'])->name('forgot.customer.password');

Route::get('customer/password/email'.config('apps.general.suffix'), [FeAuthController::class, 'verifyCustomerEmail'])->name('customer.password.email');

Route::get('customer/register'.config('apps.general.suffix'), [FeAuthController::class, 'register'])->name('customer.register');

Route::post('customer/reg'.config('apps.general.suffix'), [FeAuthController::class, 'registerAccount'])->name('customer.reg');


Route::get('customer/password/update'.config('apps.general.suffix'), [FeAuthController::class, 'updatePassword'])->name('customer.update.password');

Route::post('customer/password/change'.config('apps.general.suffix'), [FeAuthController::class, 'changePassword'])->name('customer.password.reset');

Route::get('auth/redirect', [FeAuthController::class, 'redirectToGoogle'])->name('customer.auth.redirect');
Route::get('auth/callback', [FeAuthController::class, 'handleGoogleCallback'])->name('customer.auth.callback');
Route::post('send/confirm', [FeAuthController::class, 'sendConfirmCode'])->name('customer.send.confirm');

Route::group(['middleware' => ['customer']], function () {
   Route::get('customer/profile'.config('apps.general.suffix'), [FeCustomerController::class, 'profile'])->name('customer.profile');
   Route::post('customer/profile/update'.config('apps.general.suffix'), [FeCustomerController::class, 'updateProfile'])->name('customer.profile.update');
   Route::get('customer/password/reset'.config('apps.general.suffix'), [FeCustomerController::class, 'passwordForgot'])->name('customer.password.change');
   Route::post('customer/password/recovery'.config('apps.general.suffix'), [FeCustomerController::class, 'recovery'])->name('customer.password.recovery');
   Route::get('customer/logout'.config('apps.general.suffix'), [FeCustomerController::class, 'logout'])->name('customer.logout');
});

Route::get('event/{id}/canonical'.config('apps.general.suffix'), [RouterController::class, 'event'])->name('router.event')->where(['id' => '[0-9]+']);

Route::get('tag/{canonical}'.config('apps.general.suffix'), [RouterController::class, 'tag'])->name('router.tag')->where('canonical', '[a-zA-Z0-9-]+');

Route::get('{canonical}'.config('apps.general.suffix'), [RouterController::class, 'index'])->name('router.index')->where('canonical', '[a-zA-Z0-9-]+')->middleware(['post']);

Route::get('{canonical}/trang-{page}'.config('apps.general.suffix'), [RouterController::class, 'page'])->name('router.page')->where('canonical', '[a-zA-Z0-9-]+')->where('page', '[0-9]+');

/* FRONTEND SYSTEM */


/* FRONTEND AJAX ROUTE */

Route::get('ajax/post/video', [AjaxPostController::class, 'video'])->name('post.video');

Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index');

Route::get('ajax/notification/check', [AjaxNotificationController::class, 'checkNewsNotification'])->name('ajax.notification.check');

Route::post('ajax/send/code', [AjaxAuthController::class, 'getCode'])->name('ajax.send.code');

Route::get('ajax/change/alert', [AjaxDashboardController::class, 'changeAlert'])->name('ajax.change.alert');

Route::get('ajax/change/totalNotificationNew', [AjaxDashboardController::class, 'totalNotificationNew'])->name('ajax.change.totalNotificationNew');

Route::get('ajax/customer/registerEvent', [AjaxDashboardController::class, 'registerEvent'])->name('ajax.change.registerEvent');

Route::get('ajax/customer/registerNotification', [AjaxDashboardController::class, 'registerNotification'])->name('ajax.customer.registerNotification');


/* BACKEND ROUTES */


Route::group(['middleware' => ['admin','locale','backend_default_locale']], function () {
   Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

   /* USER */
   Route::group(['prefix' => 'user'], function () {
      Route::get('index', [UserController::class, 'index'])->name('user.index');
      Route::get('create', [UserController::class, 'create'])->name('user.create');
      Route::post('store', [UserController::class, 'store'])->name('user.store');
      Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
      Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
      Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
      Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
   });


   Route::group(['prefix' => 'user/catalogue'], function () {
      Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
      Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
      Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
      Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
      Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update');
      Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
      Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
      Route::get('permission', [UserCatalogueController::class, 'permission'])->name('user.catalogue.permission');
      Route::post('updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('user.catalogue.updatePermission');
   });

   Route::group(['prefix' => 'customer'], function () {
      Route::get('index', [CustomerController::class, 'index'])->name('customer.index');
      Route::get('create', [CustomerController::class, 'create'])->name('customer.create');
      Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
      Route::get('{id}/edit', [CustomerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('customer.edit');
      Route::post('{id}/update', [CustomerController::class, 'update'])->where(['id' => '[0-9]+'])->name('customer.update');
      Route::get('{id}/delete', [CustomerController::class, 'delete'])->where(['id' => '[0-9]+'])->name('customer.delete');
      Route::delete('{id}/destroy', [CustomerController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('customer.destroy');
   });


   Route::group(['prefix' => 'customer/catalogue'], function () {
      Route::get('index', [CustomerCatalogueController::class, 'index'])->name('customer.catalogue.index');
      Route::get('create', [CustomerCatalogueController::class, 'create'])->name('customer.catalogue.create');
      Route::post('store', [CustomerCatalogueController::class, 'store'])->name('customer.catalogue.store');
      Route::get('{id}/edit', [CustomerCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('customer.catalogue.edit');
      Route::post('{id}/update', [CustomerCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('customer.catalogue.update');
      Route::get('{id}/delete', [CustomerCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('customer.catalogue.delete');
      Route::delete('{id}/destroy', [CustomerCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('customer.catalogue.destroy');
      Route::get('permission', [CustomerCatalogueController::class, 'permission'])->name('customer.catalogue.permission');
      Route::post('updatePermission', [CustomerCatalogueController::class, 'updatePermission'])->name('customer.catalogue.updatePermission');
   });

   Route::group(['prefix' => 'language'], function () {
      Route::get('index', [LanguageController::class, 'index'])->name('language.index')->middleware(['admin','locale']);
      Route::get('create', [LanguageController::class, 'create'])->name('language.create');
      Route::post('store', [LanguageController::class, 'store'])->name('language.store');
      Route::get('{id}/edit', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit');
      Route::post('{id}/update', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('language.update');
      Route::get('{id}/delete', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete');
      Route::delete('{id}/destroy', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('language.destroy');
      Route::get('{id}/switch', [LanguageController::class, 'swicthBackendLanguage'])->where(['id' => '[0-9]+'])->name('language.switch');
      Route::get('{id}/{languageId}/{model}/translate', [LanguageController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('language.translate');
      Route::post('storeTranslate', [LanguageController::class, 'storeTranslate'])->name('language.storeTranslate');
   });

   Route::group(['prefix' => 'system'], function () {
      Route::get('index', [SystemController::class, 'index'])->name('system.index');
      Route::post('store', [SystemController::class, 'store'])->name('system.store');
      Route::get('{languageId}/translate', [SystemController::class, 'translate'])->where(['languageId' => '[0-9]+'])->name('system.translate');
      Route::post('{languageId}/saveTranslate', [SystemController::class, 'saveTranslate'])->where(['languageId' => '[0-9]+'])->name('system.save.translate');
   });


   Route::group(['prefix' => 'menu'], function () {
      Route::get('index', [MenuController::class, 'index'])->name('menu.index');
      Route::get('create', [MenuController::class, 'create'])->name('menu.create');
      Route::post('store', [MenuController::class, 'store'])->name('menu.store');
      Route::get('{id}/edit', [MenuController::class, 'edit'])->where(['id' => '[0-9]+'])->name('menu.edit');
      Route::get('{id}/editMenu', [MenuController::class, 'editMenu'])->where(['id' => '[0-9]+'])->name('menu.editMenu');
      Route::post('{id}/update', [MenuController::class, 'update'])->where(['id' => '[0-9]+'])->name('menu.update');
      Route::get('{id}/delete', [MenuController::class, 'delete'])->where(['id' => '[0-9]+'])->name('menu.delete');
      Route::delete('{id}/destroy', [MenuController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('menu.destroy');
      Route::get('{id}/children', [MenuController::class, 'children'])->where(['id' => '[0-9]+'])->name('menu.children');
      Route::post('{id}/saveChildren', [MenuController::class, 'saveChildren'])->where(['id' => '[0-9]+'])->name('menu.save.children');
      Route::get('{languageId}/{id}/translate', [MenuController::class, 'translate'])->where(['languageId' => '[0-9]+', 'id' => '[0-9]+'])->name('menu.translate');
      Route::post('{languageId}/saveTranslate', [MenuController::class, 'saveTranslate'])->where(['languageId' => '[0-9]+'])->name('menu.translate.save');
   });


   Route::group(['prefix' => 'post/catalogue'], function () {
      Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
      Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
      Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
      Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
      Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update');
      Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
      Route::delete('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
   });

   Route::group(['prefix' => 'post'], function () {
      Route::get('index', [PostController::class, 'index'])->name('post.index');
      Route::get('create', [PostController::class, 'create'])->name('post.create');
      Route::post('store', [PostController::class, 'store'])->name('post.store');
      Route::get('{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
      Route::post('{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update');
      Route::get('{id}/delete', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
      Route::delete('{id}/destroy', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
   });

   Route::group(['prefix' => 'permission'], function () {
      Route::get('index', [PermissionController::class, 'index'])->name('permission.index');
      Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
      Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
      Route::get('{id}/edit', [PermissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('permission.edit');
      Route::post('{id}/update', [PermissionController::class, 'update'])->where(['id' => '[0-9]+'])->name('permission.update');
      Route::get('{id}/delete', [PermissionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('permission.delete');
      Route::delete('{id}/destroy', [PermissionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('permission.destroy');
   });

   Route::group(['prefix' => 'slide'], function () {
      Route::get('index', [SlideController::class, 'index'])->name('slide.index');
      Route::get('create', [SlideController::class, 'create'])->name('slide.create');
      Route::post('store', [SlideController::class, 'store'])->name('slide.store');
      Route::get('{id}/edit', [SlideController::class, 'edit'])->where(['id' => '[0-9]+'])->name('slide.edit');
      Route::post('{id}/update', [SlideController::class, 'update'])->where(['id' => '[0-9]+'])->name('slide.update');
      Route::get('{id}/delete', [SlideController::class, 'delete'])->where(['id' => '[0-9]+'])->name('slide.delete');
      Route::delete('{id}/destroy', [SlideController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('slide.destroy');
   });

   Route::group(['prefix' => 'widget'], function () {
      Route::get('index', [WidgetController::class, 'index'])->name('widget.index');
      Route::get('create', [WidgetController::class, 'create'])->name('widget.create');
      Route::post('store', [WidgetController::class, 'store'])->name('widget.store');
      Route::get('{id}/edit', [WidgetController::class, 'edit'])->where(['id' => '[0-9]+'])->name('widget.edit');
      Route::post('{id}/update', [WidgetController::class, 'update'])->where(['id' => '[0-9]+'])->name('widget.update');
      Route::get('{id}/delete', [WidgetController::class, 'delete'])->where(['id' => '[0-9]+'])->name('widget.delete');
      Route::delete('{id}/destroy', [WidgetController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('widget.destroy');
      Route::get('{languageId}/{id}/translate', [WidgetController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('widget.translate');
      Route::post('saveTranslate', [WidgetController::class, 'saveTranslate'])->name('widget.saveTranslate');
   });

   Route::group(['prefix' => 'code'], function () {

      Route::get('index', [CodeController::class, 'index'])->name('code.index');

      Route::get('create', [CodeController::class, 'create'])->name('code.create');

      Route::post('store', [CodeController::class, 'store'])->name('code.store');

      Route::get('{id}/edit', [CodeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('code.edit');

      Route::post('{id}/update', [CodeController::class, 'update'])->where(['id' => '[0-9]+'])->name('code.update');

      Route::get('{id}/delete', [CodeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('code.delete');

      Route::delete('{id}/destroy', [CodeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('code.destroy');

   });

   Route::group(['prefix' => 'tag'], function () {

      Route::get('index', [TagController::class, 'index'])->name('tag.index');

      Route::get('create', [TagController::class, 'create'])->name('tag.create');

      Route::post('store', [TagController::class, 'store'])->name('tag.store');

      Route::get('{id}/edit', [TagController::class, 'edit'])->where(['id' => '[0-9]+'])->name('tag.edit');

      Route::post('{id}/update', [TagController::class, 'update'])->where(['id' => '[0-9]+'])->name('tag.update');

      Route::get('{id}/delete', [TagController::class, 'delete'])->where(['id' => '[0-9]+'])->name('tag.delete');

      Route::delete('{id}/destroy', [TagController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('tag.destroy');

   });

   Route::group(['prefix' => 'city'], function () {

      Route::get('index', [CityController::class, 'index'])->name('city.index');

      Route::get('create', [CityController::class, 'create'])->name('city.create');

      Route::post('store', [CityController::class, 'store'])->name('city.store');

      Route::get('{id}/edit', [CityController::class, 'edit'])->where(['id' => '[0-9]+'])->name('city.edit');

      Route::post('{id}/update', [CityController::class, 'update'])->where(['id' => '[0-9]+'])->name('city.update');

      Route::get('{id}/delete', [CityController::class, 'delete'])->where(['id' => '[0-9]+'])->name('city.delete');

      Route::delete('{id}/destroy', [CityController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('city.destroy');

   });

   Route::group(['prefix' => 'color'], function () {

      Route::get('index', [ColorController::class, 'index'])->name('color.index');

      Route::get('create', [ColorController::class, 'create'])->name('color.create');

      Route::post('store', [ColorController::class, 'store'])->name('color.store');

      Route::get('{id}/edit', [ColorController::class, 'edit'])->where(['id' => '[0-9]+'])->name('color.edit');

      Route::post('{id}/update', [ColorController::class, 'update'])->where(['id' => '[0-9]+'])->name('color.update');

      Route::get('{id}/delete', [ColorController::class, 'delete'])->where(['id' => '[0-9]+'])->name('color.delete');

      Route::delete('{id}/destroy', [ColorController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('color.destroy');

   });

   Route::group(['prefix' => 'homestay'], function () {

      Route::get('index', [HomeStayController::class, 'index'])->name('homestay.index');

      Route::get('create', [HomeStayController::class, 'create'])->name('homestay.create');

      Route::post('store', [HomeStayController::class, 'store'])->name('homestay.store');

      Route::get('{id}/edit', [HomeStayController::class, 'edit'])->where(['id' => '[0-9]+'])->name('homestay.edit');

      Route::post('{id}/update', [HomeStayController::class, 'update'])->where(['id' => '[0-9]+'])->name('homestay.update');

      Route::get('{id}/delete', [HomeStayController::class, 'delete'])->where(['id' => '[0-9]+'])->name('homestay.delete');

      Route::delete('{id}/destroy', [HomeStayController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('homestay.destroy');

   });

   /* AJAX */
  
   Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');

   Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');

   Route::get('ajax/dashboard/getMenu', [AjaxDashboardController::class, 'getMenu'])->name('ajax.dashboard.getMenu');
   
   Route::post('ajax/menu/createCatalogue', [AjaxMenuController::class, 'createCatalogue'])->name('ajax.menu.createCatalogue');

   Route::post('ajax/menu/drag', [AjaxMenuController::class, 'drag'])->name('ajax.menu.drag');

   Route::post('ajax/menu/deleteMenu', [AjaxMenuController::class, 'deleteMenu'])->name('ajax.menu.deleteMenu');

   Route::get('ajax/dashboard/findModelObject', [AjaxDashboardController::class, 'findModelObject'])->name('ajax.dashboard.findModelObject');
   
   Route::post('ajax/slide/order', [AjaxSlideController::class, 'order'])->name('ajax.slide.order');
   
   Route::get('ajax/source/getAllSource', [AjaxSourceController::class, 'getAllSource'])->name('ajax.getAllSource');

   Route::get('ajax/post/findTag', [AjaxPostController::class, 'findTag'])->name('ajax.post.findTag');
   
});


Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');

Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::post('login', [AuthController::class, 'login'])->name('auth.login');
