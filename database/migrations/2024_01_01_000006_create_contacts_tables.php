<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('subject', 255);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255);
            $table->string('phone', 20)->nullable();
            $table->string('subject', 255);
            $table->text('message');
            $table->datetime('created_at');

            $table->index('email');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('contacts');
    }
};
