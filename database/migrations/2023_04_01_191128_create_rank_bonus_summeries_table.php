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
        Schema::create('rank_bonus_summeries', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('eligible_rank_levels')->nullable()/*->default('[]')*/;
            $table->json('rank_package_requirements')->nullable()/*->default('[]')*/;
            $table->json('eligible_rankers')->nullable()/*->default('[]')*/;
            $table->integer('eligible_rank_level_count')->nullable();
            $table->integer('total_rank_bonus_percentage')->nullable()->default(10);
            $table->integer('one_rank_bonus_percentage')->nullable()->default(2);
            $table->double('monthly_total_sale')->default(0)->nullable();
            $table->double('total_bonus_amount')->default(0)->nullable();
            $table->double('one_rank_bonus_amount')->default(0)->nullable();
            $table->double('remaining_bonus_amount')->default(0)->nullable();
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
        Schema::dropIfExists('rank_bonus_summeries');
    }
};
