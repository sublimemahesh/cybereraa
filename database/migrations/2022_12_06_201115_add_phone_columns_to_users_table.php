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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')->constrained('users')->onDelete('no action');
            $table->string('username')->nullable()->after('parent_id')->unique();
            $table->string('phone')->nullable()->after('email_verified_at');
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->dropColumn('username');
            $table->dropColumn('phone');
            $table->dropColumn('phone_verified_at');
            $table->dropSoftDeletes();
        });
    }
};
