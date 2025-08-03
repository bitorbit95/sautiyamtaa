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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->enum('donation_type', ['one_time', 'monthly'])->default('one_time');
            $table->enum('payment_method', ['mpesa', 'card', 'bank'])->default('mpesa');
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('mpesa_checkout_request_id')->nullable();
            $table->string('mpesa_receipt_number')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            $table->json('payment_data')->nullable(); // Store additional payment info
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index(['email', 'created_at']);
            $table->index('mpesa_checkout_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};