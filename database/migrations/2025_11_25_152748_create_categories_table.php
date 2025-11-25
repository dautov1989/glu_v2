<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // Иерархия категорий
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            
            // Основная информация
            $table->string('title');
            $table->string('slug')->unique();
            
            // Уровень вложенности (0 = корневая, 1-3 = подкатегории)
            $table->unsignedTinyInteger('level')->default(0);
            
            // Порядок сортировки
            $table->unsignedInteger('order')->default(0);
            
            // Статус активности
            $table->boolean('is_active')->default(true);
            
            // Описание для SEO и контента
            $table->text('description')->nullable();
            
            // SEO поля
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            
            // Дополнительные поля для будущего расширения
            $table->string('icon')->nullable(); // Иконка категории
            $table->string('image')->nullable(); // Изображение категории
            $table->json('settings')->nullable(); // Дополнительные настройки в JSON
            
            $table->timestamps();
            
            // Индексы для оптимизации запросов
            $table->index('parent_id');
            $table->index('level');
            $table->index('is_active');
            $table->index(['parent_id', 'order']); // Для сортировки внутри родителя
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
