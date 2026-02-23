<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo_path')->nullable()->after('email');
            $table->integer('kkm')->default(75)->after('profile_photo_path');
            $table->boolean('dark_mode')->default(false)->after('kkm');
            $table->text('quote')->nullable()->after('dark_mode');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_photo_path', 'kkm', 'dark_mode', 'quote']);
        });
    }
};