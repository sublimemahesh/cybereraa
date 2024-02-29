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
        Schema::table('ranks', function (Blueprint $table) {
            $table->integer('eligibility')->nullable()->default(0)->comment('DEPRECATED')->change();
            $table->json('eligibility_positions')->nullable()->comment('DEPRECATED')->change();
            $table->json('completed_requirements')->nullable()->after('eligibility_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ranks', function (Blueprint $table) {
            //
        });
    }
};
