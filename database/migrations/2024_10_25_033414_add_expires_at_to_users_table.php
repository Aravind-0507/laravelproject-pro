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
        // Check if the 'expires_at' column does not exist before adding it
        if (!Schema::hasColumn('users', 'expires_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('expires_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'expires_at' column if the migration is rolled back
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
        });
    }
};
