<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPersonalAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Ubah tipe data dari 'tokenable_id' menjadi UUID
            $table->uuid('tokenable_id')->change();
        });
    }

    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Kembalikan tipe data ke asalnya jika perlu rollback
            $table->unsignedBigInteger('tokenable_id')->change();
        });
    }
}
