<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('xp')->default(0)->after('remember_token');
            $table->integer('level')->default(1)->after('xp');
            $table->integer('total_notes_count')->default(0)->after('level');
            $table->integer('completed_tasks_count')->default(0)->after('total_notes_count');
            $table->integer('high_scores_count')->default(0)->after('completed_tasks_count');
            $table->integer('attendance_count')->default(0)->after('high_scores_count');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'xp',
                'level',
                'total_notes_count',
                'completed_tasks_count',
                'high_scores_count',
                'attendance_count'
            ]);
        });
    }
};