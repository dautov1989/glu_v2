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
        Schema::create('content_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('suggested_title');
            $table->text('content_guidelines');
            $table->json('keywords')->nullable();
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->integer('priority')->default(1);
            $table->timestamps();

            $table->index(['category_id', 'is_used']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_suggestions');
    }
};
