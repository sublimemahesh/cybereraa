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
        Schema::create('purchased_staking_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('purchaser_id')->nullable()->constrained('users')->onDelete('no action');
            $table->foreignId('staking_plan_id')->nullable()->constrained()->onDelete('no action');
            $table->double('invested_amount')->nullable()->default(0);
            $table->integer('interest_rate')->nullable();
            $table->enum('status', ['PENDING', 'ACTIVE', 'EXPIRED', 'HOLD', 'BAN']);
            $table->dateTime('maturity_date')->nullable();
            $table->json('package_info')->nullable();
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
        Schema::dropIfExists('purchased_staking_plans');
    }
};
