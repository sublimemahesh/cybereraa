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
        Schema::table('purchased_package', function (Blueprint $table) {
            $table->double('investment_profit')->nullable()->default(300)->after('invested_amount')->comment('in percentage (%)');
            $table->double('level_commission_profit')->nullable()->default(100)->after('investment_profit')->comment('in percentage (%)');
            $table->double('earned_profit')->nullable()->default(0)->after('level_commission_profit')->comment('in percentage (%)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_package', function (Blueprint $table) {
            //
        });
    }
};
