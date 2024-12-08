<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kyc_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('video_verification_url')->nullable();
            $table->boolean('address_verification')->default(false);
            $table->boolean('email_verified')->default(false);
            $table->boolean('phone_verified')->default(false);
            $table->enum('document_type', ['passport', 'driving_license', 'id_card'])->nullable();
            $table->string('document_url')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_verifications');
    }
};
