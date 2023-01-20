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
        Schema::create('wallet_topup_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unsigned()->constrained()->onDelete('no action');
            $table->foreignId('receiver_id')->nullable()->unsigned()->constrained('users')->onDelete('no action');
            $table->double('amount')->nullable()->unsigned()->default(0);
            $table->string('proof_documentation')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('wallet_topup_histories');
    }
};
