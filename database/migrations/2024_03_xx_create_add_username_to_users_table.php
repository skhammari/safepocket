<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('name')->nullable();
        });

        // Update existing records with unique usernames
        DB::table('users')->get()->each(function ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => Str::slug($user->name) . '-' . $user->id]);
        });

        // Make the username column non-nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
