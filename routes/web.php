<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('home');
})->name('home');

// Маршрут для просмотра категорий
Route::get('/category/{slug}', function ($slug) {
    $category = \App\Models\Category::where('slug', $slug)
        ->with([
            'children',
            'posts' => function ($query) {
                $query->where('is_published', true)->orderBy('published_at', 'desc');
            }
        ])
        ->firstOrFail();

    $posts = $category->posts()->where('is_published', true)->orderBy('published_at', 'desc')->paginate(12);

    return view('category.show', compact('category', 'posts'));
})->name('category.show');

// Маршрут для просмотра отдельной статьи
Route::get('/post/{slug}', function ($slug) {
    $post = \App\Models\Post::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    // Увеличиваем счетчик просмотров
    $post->increment('views');

    return view('post.show', compact('post'));
})->name('post.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
