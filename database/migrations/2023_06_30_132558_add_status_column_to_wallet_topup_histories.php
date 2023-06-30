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
        Schema::table('wallet_topup_histories', function (Blueprint $table) {
            $table->enum('status', ['PENDING', 'SUCCESS', 'REJECTED'])->nullable()->default('SUCCESS')->after('remark');
            $table->dateTime('accepted_at')->nullable()->after('status');
            $table->dateTime('rejected_at')->nullable()->after('accepted_at');
        });
        DB::statement("ALTER TABLE `wallet_topup_histories` CHANGE `status` `status` ENUM('PENDING','SUCCESS','REJECTED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'PENDING';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_topup_histories', function (Blueprint $table) {
            //
        });
    }
};
