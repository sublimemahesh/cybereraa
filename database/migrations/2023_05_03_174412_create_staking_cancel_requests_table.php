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
        Schema::create('staking_cancel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('purchased_staking_plan_id')->nullable()->constrained('purchased_staking_plans')->onDelete('no action');
            $table->enum('status', ['PENDING', 'PROCESSING', 'APPROVED', 'CANCELLED', 'FAIL', 'REJECTED'])->default('PENDING');
            $table->text('remark')->nullable();
            $table->text('repudiate_note')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('reject_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
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
        Schema::dropIfExists('staking_cancel_requests');
    }
};
