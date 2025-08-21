<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to use raw SQL to modify the ENUM
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'printing', 'packaging', 'dispatched', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the cancelled status from the enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'printing', 'packaging', 'dispatched', 'completed') NOT NULL DEFAULT 'pending'");
    }
};