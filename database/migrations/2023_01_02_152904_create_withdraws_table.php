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
        Schema::table('wallets', function (Blueprint $table) {
            $table->double('withdraw_limit')->after('balance')->default(0);
        });

        DB::statement("ALTER TABLE `earnings` CHANGE `type` `type` ENUM('PACKAGE','DIRECT','INDIRECT','RANK_BONUS', 'RANK_GIFT','P2P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");

        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('no action');
            $table->double('amount')->unsigned()->default(0);
            $table->double('transaction_fee')->unsigned()->default(0);
            $table->enum('status', ['PROCESSING', 'SUCCESS', 'FAIL', 'REJECT'])->default('PROCESSING');
            $table->enum('type', ['P2P', 'BINANCE'])->default('BINANCE');
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
        Schema::dropIfExists('withdraws');
    }
};
