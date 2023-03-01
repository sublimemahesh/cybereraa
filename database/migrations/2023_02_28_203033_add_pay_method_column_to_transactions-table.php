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
        DB::statement("ALTER TABLE `transactions` CHANGE `status` `status` ENUM('INITIAL','PENDING','PAID','CANCELED','ERROR','REFUNDING','REFUNDED','EXPIRED','REJECTED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INITIAL';");
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('pay_method', ['MAIN', 'TOPUP', 'BINANCE', 'MANUAL'])->after('type')->default('MAIN')->nullable();
            $table->string('proof_document')->nullable()->after('pay_method');
            $table->text('repudiate_note')->nullable()->after('proof_document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
