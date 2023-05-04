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
        DB::statement("ALTER TABLE `purchased_staking_plans` CHANGE `status` `status` ENUM('PENDING','ACTIVE','CANCELLED','EXPIRED','HOLD','BAN') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
        Schema::table('purchased_staking_plans', function (Blueprint $table) {
            $table->dateTime('cancelled_at')->nullable()->after('package_info');
            $table->dateTime('expired_at')->nullable()->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchased_staking_plans', function (Blueprint $table) {
            //
        });
    }
};
