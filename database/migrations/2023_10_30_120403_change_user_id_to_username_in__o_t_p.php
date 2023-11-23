<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->renameColumn('otp_code', 'code');
            $table->dropColumn('user_id');
            $table->dropColumn('token');
            $table->dropColumn('login_id');
            $table->dropColumn('type');
            $table->dropColumn('used');
            $table->dropColumn('status');
            $table->string('username')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            //
        });
    }
};
