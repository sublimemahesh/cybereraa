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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('support_ticket_category_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('support_ticket_priority_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('support_ticket_status_id')->nullable()->constrained()->onDelete('no action');
            $table->string('subject')->nullable();
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('support_tickets');
    }
};
