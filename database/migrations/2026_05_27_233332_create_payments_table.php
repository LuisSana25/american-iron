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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
        $table->decimal('amount', 8, 2);
        $table->enum('payment_method', ['wompi_card', 'cash', 'pos']);
        $table->string('wompi_transaction_id')->nullable()->unique(); // ID único de Wompi SV
        $table->string('pos_reference')->nullable(); // Voucher físico
        $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
