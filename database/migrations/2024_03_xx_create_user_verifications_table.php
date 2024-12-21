<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('phone_verified')->default(false);
            $table->boolean('address_verified')->default(false);
            $table->boolean('biometric_verified')->default(false);
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('id_type')->nullable(); // passport, drivers_license, national_id
            $table->string('id_front_path')->nullable();
            $table->string('id_back_path')->nullable();
            $table->string('selfie_path')->nullable();
            $table->integer('stage')->default(1);
            $table->integer('max_transactions')->default(3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_verifications');
    }
}; 