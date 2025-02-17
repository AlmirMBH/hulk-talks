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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('customer');
            $table->decimal('total_amount', 8, 2);
            $table->decimal('paid_installments_amount', 8, 2);
            $table->integer('discount');
            $table->integer('basic_bonus');
            $table->integer('min_bonus_amount');
            $table->integer('bonus_plus');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
