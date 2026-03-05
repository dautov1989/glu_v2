<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            // Основная информация
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image_url')->nullable();

            // Маркетплейс
            $table->enum('marketplace', [
                'Wildberries',
                'Ozon',
                'Яндекс Маркет',
                'ЕАПТЕКА',
                'СберМегаМаркет',
                'AliExpress',
            ]);
            $table->string('marketplace_url')->nullable();

            // Рейтинг и бейдж
            $table->decimal('rating', 3, 1)->default(0);
            $table->string('badge')->nullable();

            // Характеристики (массив строк в JSON)
            $table->json('features')->nullable();

            // Отзыв (просто текст)
            $table->text('review_text')->nullable();

            // Управление
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();

            // Индексы
            $table->index(['category_id', 'is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
