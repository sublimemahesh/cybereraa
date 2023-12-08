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
        Schema::create('team_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('no action');
            $table->double('amount')->default(0)->nullable();
            $table->double('paid')->default(0)->nullable();
            $table->date('bonus_date')->nullable();
            $table->enum('bonus', ['SILVER', 'GOLD', 'DIAMOND', '10_DIRECT_SALE', '20_DIRECT_SALE', '30_DIRECT_SALE'])->nullable();
            $table->enum('type', ['TEAM_BONUS', 'SPECIAL_BONUS'])->nullable();
            $table->enum('status', ['QUALIFIED', 'DISQUALIFIED'])->nullable();
            $table->string('package_ids')->nullable()->comment('used for special bonus');
            $table->json('summery')->nullable();
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
        Schema::dropIfExists('team_bonuses');
    }
};
