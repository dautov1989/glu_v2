<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Comment;

class ClearTestPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:clear-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удалить все тестовые статьи из базы данных';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🗑️  Начинаю удаление тестовых статей...');

        // Подсчитываем количество статей
        $postsCount = Post::count();
        $commentsCount = Comment::count();

        if ($postsCount === 0) {
            $this->info('✅ База данных уже пуста. Нет статей для удаления.');
            return 0;
        }

        // Спрашиваем подтверждение
        if (!$this->confirm("Вы уверены, что хотите удалить {$postsCount} статей и {$commentsCount} комментариев?", true)) {
            $this->info('❌ Операция отменена.');
            return 0;
        }

        // Удаляем комментарии
        $this->info('Удаляю комментарии...');
        Comment::truncate();

        // Удаляем статьи
        $this->info('Удаляю статьи...');
        Post::truncate();

        $this->info("✅ Успешно удалено:");
        $this->line("   📝 Статей: {$postsCount}");
        $this->line("   💬 Комментариев: {$commentsCount}");
        $this->info('');
        $this->info('🤖 Теперь статьи будут создаваться через n8n!');

        return 0;
    }
}
