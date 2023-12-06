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
        Schema::create('trader_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_id')->nullable()->constrained('traders')->onDelete('no action');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('no action');
            $table->double('out_usdt')->nullable()->default(0)->comment('Given');
            $table->dateTime('usdt_out_time')->nullable();
            $table->double('in_usdt')->nullable()->default(0)->comment('Earned');
            $table->dateTime('usdt_in_time')->nullable();
            $table->text('reference')->nullable();
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
        Schema::dropIfExists('trader_transactions');
    }
};
