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
        Schema::create('kyc_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kyc_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('document_name')->nullable();
            $table->enum('type', ['front', 'back', 'other']);
            $table->enum('status', ['required', 'pending', 'accepted', 'rejected'])->default('required');
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
        Schema::dropIfExists('kyc_document');
    }
};
