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
        DB::statement("
            ALTER TABLE `transactions` CHANGE `pay_method` `pay_method`
                ENUM('MAIN', 'TOPUP','FREE', 'COIN_PAYMENT', 'BINANCE', 'MANUAL')
            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
