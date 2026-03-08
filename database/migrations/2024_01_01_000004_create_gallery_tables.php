<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('file_path', 255);
            $table->enum('file_type', ['image', 'video']);
            $table->string('category', 100);
            $table->string('location', 255)->nullable();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->foreignId('author_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->index('category');
            $table->index('file_type');
        });

        Schema::create('gallery_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('gallery_items')->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['gallery_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_likes');
        Schema::dropIfExists('gallery_items');
    }
};
