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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique()->index(); // e.g., ORD-20250918-0001
            $table->unsignedBigInteger('total_price')->default(0);
            $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending')->index();
            $table->string('payment_method')->default('transfer'); // transfer/manual/etc
            $table->enum('payment_status', ['unpaid', 'waiting', 'paid', 'failed'])->default('unpaid');
            $table->string('phone')->nullable(); // snapshot dari checkout
            $table->text('shipping_address');
            $table->text('notes')->nullable();
            $table->string('proof_path')->nullable(); // bukti transfer
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
