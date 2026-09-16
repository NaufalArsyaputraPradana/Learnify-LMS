<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('instructor_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();

            $table->string('thumbnail')->nullable();

            $table->decimal('price', 12, 2)->default(0);

            $table->enum('level', [
                'beginner',
                'intermediate',
                'advanced',
            ])->default('beginner');

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index(['instructor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};