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
            $table->string('name',40);
            $table->string('first_lastname',40);
            $table->string('seccond_lastname',40);
            $table->string('street', 20);
            $table->string('interior_number', 20)->nullable();
            $table->string('exterior_number', 20);
            $table->string('colony', 40);
            $table->string('zip_code',10);
            $table->string('email',50)->unique();
            $table->string('phone',20);
            $table->date("hire_date");
            $table->date("birth_date");
            $table->string("gender", 1);
            $table->string("RFC",13)->nullable()->index();
            $table->string("curp",18)->nullable()->index();
            $table->string("NSS",11)->nullable()->index();
            $table->integer("branch_id");
            $table->string("emergency_contact")->nullable();
            $table->integer('position_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('cancel_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->string('active', 1)->default('S'); // N = No, S = Si
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive
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
