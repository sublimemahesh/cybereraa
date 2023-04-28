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
        Schema::create('staking_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staking_package_id')->nullable()->constrained()->onDelete('no action');
            $table->string('name')->nullable();
            $table->integer('duration')->nullable()->comment('_in_days');
            $table->double('interest_rate')->nullable();
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
        Schema::dropIfExists('staking_plans');
    }
};
