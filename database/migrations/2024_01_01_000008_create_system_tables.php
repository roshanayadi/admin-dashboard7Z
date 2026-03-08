<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_history', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['email', 'phone']);
            $table->string('subject', 255)->nullable();
            $table->text('message');
            $table->integer('recipient_count')->default(0);
            $table->integer('success_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->datetime('created_at')->useCurrent();
        });

        Schema::create('sms_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sms_history_id')->constrained('sms_history')->onDelete('cascade');
            $table->string('recipient', 255);
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->text('message')->nullable();
            $table->datetime('created_at')->useCurrent();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('setting_key', 100)->primary();
            $table->text('setting_value')->nullable();
            $table->datetime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('sms_details');
        Schema::dropIfExists('sms_history');
    }
};
