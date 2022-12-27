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
        Schema::table('earnings', function (Blueprint $table) {
            $table->dropForeign(['purchased_package_id']);
            $table->dropColumn('purchased_package_id');
            $table->after('user_id', function (Blueprint $table) {
                $table->nullableMorphs('earnable');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('earnings', function (Blueprint $table) {
            $table->foreignId('purchased_package_id')->after('user_id')->nullable()->constrained('purchased_package')->onDelete('no action');
            $table->dropMorphs('earnable');
        });
    }
};
