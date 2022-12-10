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
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('nic_proof');
            $table->dropColumn('driving_lc_proof');
            $table->dropColumn('passport_proof');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('nic_proof')->after('nic')->nullable();
            $table->string('driving_lc_proof')->after('driving_lc_number')->nullable();
            $table->string('passport_proof')->after('passport_number')->nullable();
        });
    }
};
