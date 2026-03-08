<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image', 255)->nullable();
            $table->string('category', 100);
            $table->foreignId('author_id')->constrained('admins')->onDelete('cascade');
            $table->string('status', 20)->default('published');
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('category');
            $table->index('created_at');
        });

        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->text('comment');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['post_id', 'status']);
        });

        Schema::create('blog_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['post_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_likes');
        Schema::dropIfExists('blog_comments');
        Schema::dropIfExists('blog_posts');
    }
};
