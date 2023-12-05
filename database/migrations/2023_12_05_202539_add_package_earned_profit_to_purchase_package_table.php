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
            $table->double('package_earned_profit')
                ->nullable()
                ->default(0)
                ->after('level_commission_profit')
                ->comment('in percentage (%)');
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
