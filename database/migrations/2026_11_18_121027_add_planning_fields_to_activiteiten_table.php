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
        Schema::table('activiteiten', function (Blueprint $table) {
            $table->dateTime('deadline_at')->nullable()->after('time');
            $table->json('required_roles')->nullable()->after('deadline_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activiteiten', function (Blueprint $table) {
            $table->dropColumn(['deadline_at', 'required_roles']);
        });
    }
};
