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
        if (Schema::hasTable('job_positions')) {
            Schema::rename('job_positions', 'positions');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('positions')) {
            Schema::rename('positions', 'job_positions');
        }
    }

};
