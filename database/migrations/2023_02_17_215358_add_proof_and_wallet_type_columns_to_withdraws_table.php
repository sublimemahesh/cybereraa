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
        DB::statement("ALTER TABLE `withdraws` CHANGE `type` `type` ENUM('P2P','BINANCE','MANUAL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `withdraws` CHANGE `status` `status` ENUM('PENDING','PROCESSING','SUCCESS','FAIL','REJECT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING'");

        Schema::table('withdraws', function (Blueprint $table) {
            $table->enum('wallet_type', ['MAIN', 'TOPUP', 'BONUS'])->default('MAIN')->nullable()->after('type');
            $table->string('proof_document')->nullable()->after('remark');
            $table->json('payout_details')->nullable()->after('proof_document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn('wallet_type');
            $table->dropColumn('proof_document');
            $table->dropColumn('payout_details');
        });
    }
};
