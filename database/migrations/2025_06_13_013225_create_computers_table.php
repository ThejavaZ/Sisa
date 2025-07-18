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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string("name",40);
            $table->string("serial_number")->unique();
            $table->integer("brand_id");
            $table->string("model");
            $table->string("description");
            $table->string("specify");
            $table->string("os");
            $table->date('purchase_date')->nullable();
            $table->date("warranty_until")->nullable();
            $table->integer("branch_id");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('cancel_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->string("active",1)->default("S");
            $table->boolean("status")->default(1);
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
        Schema::dropIfExists('computers');
    }
};
