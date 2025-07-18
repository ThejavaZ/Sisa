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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('level');
            $table->integer('department_id');
            $table->string('description')->nullable();
            $table->decimal('salary', 10, 2); // Salary can be null
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('cancel_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->string("active",1)->default("S"); // N = No, S = Si
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive
            $table->timestamps();
            $table->timestamp('cancel_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
