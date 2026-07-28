<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan kolom user_id setelah kolom id (atau setelah kolom yang sesuai)
            // nullable() digunakan agar data transaksi lama yang tidak punya user_id tidak error
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};