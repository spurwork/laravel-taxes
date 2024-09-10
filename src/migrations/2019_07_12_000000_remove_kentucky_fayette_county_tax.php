<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::table('taxes')->where('name', 'Fayette County Kentucky Tax')->delete();
    }
};
