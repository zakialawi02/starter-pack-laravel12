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
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_id')->nullable()->after('password');
            $table->string('provider_name')->nullable()->after('provider_id');
            $table->string('provider_token')->nullable()->after('provider_name');
            $table->string('provider_refresh_token')->nullable()->after('provider_token');

            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'provider_id',
                'provider_name',
                'provider_token',
                'provider_refresh_token',
            ]);

            $table->string('password')->nullable(false)->change();
        });
    }
};
