<?php

use App\Enums\AdminWalletEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `admin_wallets` CHANGE `wallet_type` `wallet_type` ENUM('" . implode("','", AdminWalletEnum::walletTypes()) . "') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
        DB::statement("ALTER TABLE `admin_wallet_transactions` CHANGE `type` `type` ENUM('" . implode("','", AdminWalletEnum::walletTypes()) . "') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
        DB::statement("ALTER TABLE `admin_wallet_withdrawals` CHANGE `type` `type` ENUM('" . implode("','", AdminWalletEnum::walletTypes()) . "') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");

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
