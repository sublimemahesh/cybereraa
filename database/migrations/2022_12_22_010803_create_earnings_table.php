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
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('purchased_package_id')->nullable()->constrained('purchased_package')->onDelete('no action');
            $table->enum('currency', ['USDT'])->nullable()->default('USDT');
            $table->double('amount')->nullable();
            $table->enum('type', ['PACKAGE', 'DIRECT', 'INDIRECT']);
            $table->enum('status', ['RECEIVED', 'HOLD', 'CANCELED']);
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
        Schema::dropIfExists('earnings');
    }
};
