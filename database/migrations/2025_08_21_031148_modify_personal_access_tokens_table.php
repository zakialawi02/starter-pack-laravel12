<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPersonalAccessTokensTable extends Migration
{
    public function up()
    {
        // No longer needed as the base migration was fixed to use uuidMorphs
    }

    public function down()
    {
        // No longer needed
    }
}
