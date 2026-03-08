<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('full_name', 100);
            $table->string('role', 50)->default('admin');
            $table->string('permissions', 255)->nullable();
            $table->string('status', 50)->default('active');
            $table->datetime('last_login')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
