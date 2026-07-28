<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            // Untuk fitur Superadmin: 'pending', 'approved', 'rejected'
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('logo');
        });
    }
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
