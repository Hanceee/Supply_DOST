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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('article_description');
            $table->decimal('price', 8, 2);
            $table->foreignId('supplier_id');
            $table->foreignId('user_id');
            $table->decimal('quality_rating');
            $table->decimal('completeness_rating');
            $table->decimal('conformity_rating');
            $table->decimal('rating')->default(0);
            $table->string('remarks');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
