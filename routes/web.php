<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/search/suggestions', [\App\Http\Controllers\SearchController::class, 'suggestions'])->name('search.suggestions');

// SEO Routes
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots.txt');

// RSS Feed
Route::get('/feed', [\App\Http\Controllers\FeedController::class, 'rss'])->name('rss.feed');

// API Tester
Route::view('/api-tester', 'api-tester')->name('api.tester');

// Категории
Route::get('/category/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

// Все статьи
Route::get('/articles', [\App\Http\Controllers\PostController::class, 'index'])->name('articles.index');

// Просмотр статьи
Route::get('/post/{slug}', [\App\Http\Controllers\PostController::class, 'show'])->name('post.show');

// Инструменты
Route::get('/tools/insulin-calculator', [\App\Http\Controllers\ToolsController::class, 'insulinCalculator'])->name('tools.insulin-calculator');
Route::get('/tools/can-i-eat', [\App\Http\Controllers\ToolsController::class, 'canIEat'])->name('tools.can-i-eat');
Route::get('/tools/faq', [\App\Http\Controllers\ToolsController::class, 'faq'])->name('tools.faq');
Route::get('/tools/carbs-table', [\App\Http\Controllers\ToolsController::class, 'carbsTable'])->name('tools.carbs-table');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

    // Admin: Comment Moderation
    Route::get('comments', \App\Livewire\Admin\CommentModeration::class)->name('comments');

    // Admin: Affiliate Links
    Route::prefix('affiliate-links')->name('affiliate-links.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'store'])->name('store');
        Route::get('/{affiliateLink}/edit', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'edit'])->name('edit');
        Route::put('/{affiliateLink}', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'update'])->name('update');
        Route::delete('/{affiliateLink}', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'destroy'])->name('destroy');
        Route::post('/{affiliateLink}/toggle', [\App\Http\Controllers\Admin\AffiliateLinkController::class, 'toggleActive'])->name('toggle');
    });

    // Admin: Users
    Route::get('users', \App\Livewire\Admin\UserList::class)->name('users');

    // Admin: API Tester
    Route::get('api-tester', \App\Livewire\Admin\ApiTester::class)->name('api-tester');

    // Admin: Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/profile', \App\Livewire\Settings\Profile::class)->name('profile');
        Route::get('/password', \App\Livewire\Settings\Password::class)->name('password');
        Route::get('/appearance', \App\Livewire\Settings\Appearance::class)->name('appearance');
        Route::get('/two-factor', \App\Livewire\Settings\TwoFactor::class)->name('two-factor');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
