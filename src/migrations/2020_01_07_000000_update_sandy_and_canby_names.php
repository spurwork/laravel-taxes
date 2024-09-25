<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::table('governmental_unit_areas')->where('name', 'Sandy Oregon Employer Tax')->update([
            'name' => 'Sandy Oregon Employer Transit Tax',
        ]);

        DB::table('governmental_unit_areas')->where('name', 'Canby Oregon Employer Tax')->update([
            'name' => 'Canby Oregon Employer Transit Tax',
        ]);
    }
};
