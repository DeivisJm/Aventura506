<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Public Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TourController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AdminAccommodationController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminExchangeRateController;
use App\Http\Controllers\Admin\AdminTourController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
| These routes are accessible to all visitors.
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/accommodations', [AccommodationController::class, 'index'])
    ->name('accommodations.index');

Route::get('/about_us', fn() => view('pages.about_us'))
    ->name('about');

Route::get('/contact', fn() => view('pages.contact'))
    ->name('contact');

/*
|--------------------------------------------------------------------------
| Public Tour Routes
|--------------------------------------------------------------------------
| These routes handle the public tour listing and detail pages.
*/
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');

/*
|--------------------------------------------------------------------------
| Public Form Actions
|--------------------------------------------------------------------------
| These routes process booking, subscription, and contact requests.
*/
Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

Route::post('/subscribe', [SubscriberController::class, 'store'])
    ->name('subscribe.store');

Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send');

/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
| Stores the selected locale in session and redirects back.
*/
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| These routes handle login, register, and username validation.
*/
Route::get('/login', [AdminAuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AdminAuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AdminAuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AdminAuthController::class, 'register'])
    ->name('register.post');

/*
|--------------------------------------------------------------------------
| Registration Utilities
|--------------------------------------------------------------------------
| Used to validate username availability during registration.
*/
Route::get('/register/check-username', [AdminAuthController::class, 'checkUsername'])
    ->name('register.check-username');

/*
|--------------------------------------------------------------------------
| Legacy Redirects
|--------------------------------------------------------------------------
| Keeps old admin auth URLs working temporarily.
*/
Route::redirect('/admin/login', '/login');
Route::redirect('/admin/register', '/register');

/*
|--------------------------------------------------------------------------
| Authenticated Logout Route
|--------------------------------------------------------------------------
| This route remains globally named as admin.logout so existing
| layout references continue working without changes.
*/
Route::middleware(['auth'])->post('/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Authenticated Account Routes
|--------------------------------------------------------------------------
| These routes are available to any logged-in user.
*/
Route::middleware(['auth'])->prefix('account')->name('account.')->group(function () {
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/bookings', [AccountController::class, 'bookings'])->name('bookings');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
| These routes are restricted to authenticated superadmin users.
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin', 'no.cache'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | Exchange Rates
        |--------------------------------------------------------------------------
        */
        Route::resource('exchange-rates', AdminExchangeRateController::class)
            ->names('admin.exchange_rates');

        /*
        |--------------------------------------------------------------------------
        | Accommodations
        |--------------------------------------------------------------------------
        */
        Route::get('/accommodations', [AdminAccommodationController::class, 'index'])
            ->name('admin.accommodations.index');

        Route::get('/accommodations/create', [AdminAccommodationController::class, 'create'])
            ->name('admin.accommodations.create');

        Route::post('/accommodations', [AdminAccommodationController::class, 'store'])
            ->name('admin.accommodations.store');

        Route::get('/accommodations/{accommodation}/edit', [AdminAccommodationController::class, 'edit'])
            ->name('admin.accommodations.edit');

        Route::put('/accommodations/{accommodation}', [AdminAccommodationController::class, 'update'])
            ->name('admin.accommodations.update');

        Route::patch('/accommodations/{accommodation}/toggle', [AdminAccommodationController::class, 'toggle'])
            ->name('admin.accommodations.toggle');

        Route::patch('/accommodations/{accommodation}/position', [AdminAccommodationController::class, 'updatePosition'])
            ->name('admin.accommodations.update-position');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/users/create', [AdminUserController::class, 'create'])
            ->name('admin.users.create');

        Route::post('/users', [AdminUserController::class, 'store'])
            ->name('admin.users.store');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('admin.users.update');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('admin.users.destroy');

        /*
        |--------------------------------------------------------------------------
        | Subscribers
        |--------------------------------------------------------------------------
        */
        Route::get('/subscribers/{subscriber}/edit', [AdminUserController::class, 'editSubscriber'])
            ->name('admin.subscribers.edit');

        Route::put('/subscribers/{subscriber}', [AdminUserController::class, 'updateSubscriber'])
            ->name('admin.subscribers.update');

        Route::delete('/subscribers/{subscriber}', [AdminUserController::class, 'destroySubscriber'])
            ->name('admin.subscribers.destroy');

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        Route::get('/categories', [AdminCategoryController::class, 'index'])
            ->name('admin.categories.index');

        Route::get('/categories/create', [AdminCategoryController::class, 'create'])
            ->name('admin.categories.create');

        Route::post('/categories', [AdminCategoryController::class, 'store'])
            ->name('admin.categories.store');

        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])
            ->name('admin.categories.edit');

        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])
            ->name('admin.categories.update');

        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])
            ->name('admin.categories.destroy');

        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */
        Route::get('/companies', [AdminCompanyController::class, 'index'])
            ->name('admin.companies.index');

        Route::get('/companies/create', [AdminCompanyController::class, 'create'])
            ->name('admin.companies.create');

        Route::post('/companies', [AdminCompanyController::class, 'store'])
            ->name('admin.companies.store');

        Route::get('/companies/{company}/edit', [AdminCompanyController::class, 'edit'])
            ->name('admin.companies.edit');

        Route::put('/companies/{company}', [AdminCompanyController::class, 'update'])
            ->name('admin.companies.update');

        Route::delete('/companies/{company}', [AdminCompanyController::class, 'destroy'])
            ->name('admin.companies.destroy');

        /*
        |--------------------------------------------------------------------------
        | Tour Schedules
        |--------------------------------------------------------------------------
        */
        Route::post('/schedules/{schedule}/toggle', [AdminTourController::class, 'toggleSchedule'])
            ->name('admin.schedules.toggle');

        /*
        |--------------------------------------------------------------------------
        | Tours
        |--------------------------------------------------------------------------
        */
        Route::get('/tours', [AdminTourController::class, 'index'])
            ->name('admin.tours.index');

        Route::get('/tours/create', [AdminTourController::class, 'create'])
            ->name('admin.tours.create');

        Route::post('/tours', [AdminTourController::class, 'store'])
            ->name('admin.tours.store');

        Route::get('/tours/{tour}/edit', [AdminTourController::class, 'edit'])
            ->name('admin.tours.edit');

        Route::put('/tours/{tour}', [AdminTourController::class, 'update'])
            ->name('admin.tours.update');

        Route::patch('/tours/{tour}/toggle', [AdminTourController::class, 'toggle'])
            ->name('admin.tours.toggle');

        /*
        |--------------------------------------------------------------------------
        | Tour Ordering
        |--------------------------------------------------------------------------
        */
        Route::patch('/tours/{tour}/position', [AdminTourController::class, 'updatePosition'])
            ->name('admin.tours.update-position');
    });
