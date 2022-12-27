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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('purchased_package_id')->nullable()->constrained('purchased_package')->onDelete('no action');
            $table->double('amount')->nullable();
            $table->double('paid')->nullable();
            $table->enum('type', ['DIRECT', 'INDIRECT']);
            $table->enum('status', ['QUALIFIED', 'DISQUALIFIED', 'COMPLETED'])->nullable();
            $table->timestamp('last_earned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
    }
};
