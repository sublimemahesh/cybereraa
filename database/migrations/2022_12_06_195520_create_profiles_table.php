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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('set null');
            $table->string('street')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('home_phone')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->string('nic')->nullable();
            $table->string('nic_proof')->nullable();
            $table->timestamp('nic_verified_at')->nullable();
            $table->string('driving_lc_number')->nullable();
            $table->string('driving_lc_proof')->nullable();
            $table->timestamp('driving_lc_verified_at')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_proof')->nullable();
            $table->timestamp('passport_verified_at')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('profiles');
    }
};
