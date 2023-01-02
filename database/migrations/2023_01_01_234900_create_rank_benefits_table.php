<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('rank_id')->nullable()->constrained()->onDelete('no action');
            $table->double('amount')->nullable();
            $table->double('paid')->nullable()->default(0);
            $table->enum('type', ['RANK_BONUS', 'RANK_GIFT']);
            $table->enum('status', ['QUALIFIED', 'DISQUALIFIED', 'COMPLETED'])->nullable();
            $table->timestamp('last_earned_at')->nullable();
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
        Schema::dropIfExists('rank_benefits');
    }
};
