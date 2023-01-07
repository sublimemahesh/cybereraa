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
        Schema::create('support_ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_ticket_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->comment('Replied admin')->constrained('users')->onDelete('no action');
            $table->text('reply')->nullable();
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
        Schema::dropIfExists('support_ticket_replies');
    }
};
