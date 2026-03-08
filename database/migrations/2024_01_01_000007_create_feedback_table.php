<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 255)->nullable();
            $table->text('feedback');
            $table->tinyInteger('rating')->unsigned();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('approved')->default(true);
            $table->timestamps();

            $table->index('rating');
            $table->index('approved');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
