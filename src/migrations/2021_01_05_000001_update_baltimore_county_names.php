<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private const NAMES = [
        'Allegany, MD' => 'Allegany County, MD',
        'Anne Arundel, MD' => 'Anne Arundel County, MD',
        'Baltimore, MD' => 'Baltimore County, MD',
        'Calvert, MD' => 'Calvert County, MD',
        'Caroline, MD' => 'Caroline County, MD',
        'Carroll, MD' => 'Carroll County, MD',
        'Cecil, MD' => 'Cecil County, MD',
        'Charles, MD' => 'Charles County, MD',
        'Dorchester, MD' => 'Dorchester County, MD',
        'Frederick, MD' => 'Frederick County, MD',
        'Garrett, MD' => 'Garrett County, MD',
        'Harford, MD' => 'Harford County, MD',
        'Howard, MD' => 'Howard County, MD',
        'Kent, MD' => 'Kent County, MD',
        'Montgomery, MD' => 'Montgomery County, MD',
        'Prince Georges, MD' => 'Prince Georges County, MD',
        'Queen Annes, MD' => 'Queen Annes County, MD',
        'St. Marys, MD' => 'St. Marys County, MD',
        'Somerset, MD' => 'Somerset County, MD',
        'Talbot, MD' => 'Talbot County, MD',
        'Washington, MD' => 'Washington County, MD',
        'Wicomico, MD' => 'Wicomico County, MD',
        'Worcester, MD' => 'Worcester County, MD',
    ];

    public function up()
    {
        foreach (self::NAMES as $old => $new) {
            DB::table('governmental_unit_areas')
                ->where('name', $old)
                ->update(['name' => $new]);
        }
    }
};
