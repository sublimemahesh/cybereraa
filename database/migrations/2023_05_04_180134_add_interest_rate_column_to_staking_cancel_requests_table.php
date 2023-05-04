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
        Schema::table('purchased_staking_plans', function (Blueprint $table) {
            $table->double('interest_rate')->change();
        });

        Schema::table('staking_cancel_requests', function (Blueprint $table) {
            $table->double('total_released_amount')->nullable()->default(0)->after('approved_at');
            $table->double('interest_rate')->nullable()->default(0)->after('total_released_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staking_cancel_requests', function (Blueprint $table) {
            //
        });
    }
};
