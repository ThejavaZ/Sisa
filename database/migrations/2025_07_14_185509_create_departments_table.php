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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('head_id');
            $table->string('cost_center', 20);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('cancel_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->string('active',1)->default('S');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('departments');
    }
};
