<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    $articlesCount = \App\Models\Post::where('is_published', true)->count();
    $usersCount = \App\Models\User::count();
    $latestPosts = \App\Models\Post::where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->limit(6)
        ->get();
    return view('home', compact('articlesCount', 'usersCount', 'latestPosts'));
})->name('home');

Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/search/suggestions', [\App\Http\Controllers\SearchController::class, 'suggestions'])->name('search.suggestions');

// SEO Routes
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots.txt');

// RSS Feed
Route::get('/feed', function () {
    $posts = \App\Models\Post::where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->limit(20)
        ->get();

    return response()
        ->view('feed.rss', compact('posts'))
        ->header('Content-Type', 'application/xml');
})->name('rss.feed');

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

    // Получаем параметр сортировки из query string
    $sortBy = request()->get('sort', 'date_desc');

    // Строим запрос для постов
    $postsQuery = $category->posts()->where('is_published', true);

    // Применяем сортировку
    switch ($sortBy) {
        case 'date_asc':
            $postsQuery->orderBy('published_at', 'asc');
            break;
        case 'date_desc':
            $postsQuery->orderBy('published_at', 'desc');
            break;
        case 'views':
            $postsQuery->orderBy('views', 'desc');
            break;
        case 'title':
            $postsQuery->orderBy('title', 'asc');
            break;
        default:
            $postsQuery->orderBy('published_at', 'desc');
    }

    $posts = $postsQuery->paginate(12)->appends(['sort' => $sortBy]);

    return view('category.show', compact('category', 'posts', 'sortBy'));
})->name('category.show');

// Маршрут для просмотра всех статей
Route::get('/articles', function () {
    $sortBy = request()->get('sort', 'date_desc');
    $postsQuery = \App\Models\Post::where('is_published', true);

    switch ($sortBy) {
        case 'date_asc':
            $postsQuery->orderBy('published_at', 'asc');
            break;
        case 'date_desc':
            $postsQuery->orderBy('published_at', 'desc');
            break;
        case 'views':
            $postsQuery->orderBy('views', 'desc');
            break;
        case 'title':
            $postsQuery->orderBy('title', 'asc');
            break;
        default:
            $postsQuery->orderBy('published_at', 'desc');
    }

    $posts = $postsQuery->paginate(12)->appends(['sort' => $sortBy]);

    return view('articles.index', compact('posts', 'sortBy'));
})->name('articles.index');

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

    // Admin: Comment Moderation
    Route::get('admin/comments', \App\Livewire\Admin\CommentModeration::class)->name('admin.comments');
});
