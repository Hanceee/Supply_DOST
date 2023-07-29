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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('representative_name');
            $table->string('position_designation');
            $table->string('company_address');
            $table->string('office_contact');
            $table->string('email');
            $table->string('business_permit_number');
            $table->string('tin');
            $table->string('philgeps_registration_number');
            $table->foreignId('category_id');
            $table->integer('transaction_avg_rating')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
