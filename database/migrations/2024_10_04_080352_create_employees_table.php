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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->date('joining_date')->nullable();
            $table->integer('phone');
            $table->boolean('is_active')->default(false);
            $table->integer('role')->default(1);
            $table->string('password'); 
            $table->timestamp('expires_at')->useCurrent(); // New expires_at column with current timestamp
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};