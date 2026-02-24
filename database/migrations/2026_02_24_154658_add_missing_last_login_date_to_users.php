<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya tambah last_login_date jika belum ada
            if (!Schema::hasColumn('users', 'last_login_date')) {
                $table->date('last_login_date')->nullable()->after('streak');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'last_login_date')) {
                $table->dropColumn('last_login_date');
            }
        });
    }
};