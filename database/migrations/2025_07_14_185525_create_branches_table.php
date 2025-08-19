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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('street', 20);
            $table->string('interior_number', 20)->nullable();
            $table->string('exterior_number', 20);
            $table->string('colony', 40);
            $table->string('zip_code',10);
            $table->string('phone',20);
            $table->boolean('is_main')->default(0);
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
        Schema::dropIfExists('branches');
    }
};
