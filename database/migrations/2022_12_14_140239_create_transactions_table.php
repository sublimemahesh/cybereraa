<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('package_id')->nullable()->constrained()->onDelete('no action');
            $table->string('merchant_trade_no')->nullable()->unique();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('currency')->nullable();
            $table->double('amount')->nullable();
            $table->double('tax')->nullable();
            $table->enum('type', ['crypto', 'wallet'])->nullable()->default('crypto');
            $table->enum('status', ["INITIAL", "PENDING", "PAID", "CANCELED", "ERROR", "REFUNDING", "REFUNDED", "EXPIRED"])->default('INITIAL');
            $table->json('create_order_request')->nullable();
            $table->json('create_order_response')->nullable();
            $table->json('status_response')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
