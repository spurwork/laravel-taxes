<?php

use Appleton\Taxes\Countries\US\Oregon\CanbyEmployer\CanbyEmployer;
use Appleton\Taxes\Countries\US\Oregon\SandyEmployer\SandyEmployer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateSandyAndCanbyNames extends Migration
{
    public function up()
    {
        DB::table('governmental_unit_areas')->where('name', 'Sandy Oregon Employer Tax')->update([
            'name' => 'Sandy Oregon Employer Transit Tax',
            'class' => SandyEmployer::class,
        ]);

        DB::table('governmental_unit_areas')->where('name', 'Canby Oregon Employer Tax')->update([
            'name' => 'Canby Oregon Employer Transit Tax',
            'class' => CanbyEmployer::class,
        ]);
    }
}
