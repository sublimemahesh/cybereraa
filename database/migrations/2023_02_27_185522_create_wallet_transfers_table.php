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
        Schema::create('wallet_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('from', ['MAIN', 'TOPUP', 'BONUS'])->nullable()->default('MAIN');
            $table->enum('to', ['MAIN', 'TOPUP', 'BONUS'])->nullable()->default('TOPUP');
            $table->double('amount')->nullable()->default(0);
            $table->double('fee')->nullable()->default(0);
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('wallet_transfers');
    }
};
