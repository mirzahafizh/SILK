<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nip', 30)->unique();
            $table->string('name', 150);
            $table->string('email')->nullable()->unique();

            $table->boolean('email_verified')->default(false);

            $table->string('password');

            $table->enum('role', ['admin', 'pjlp'])
                ->default('pjlp');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};