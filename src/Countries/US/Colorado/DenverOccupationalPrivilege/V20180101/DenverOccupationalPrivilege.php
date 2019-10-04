<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\DenverOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class DenverOccupationalPrivilege extends BaseDenverOccupationalPrivilege
{
    protected function getMonthlyWageAmount(): int
    {
        return 0;
    }

    protected function getMonthlyTaxAmount(): int
    {
        return 0;
    }

    protected function getLocalGovernmentalUnitArea(): stdClass
    {
        return DB::table('governmental_unit_areas')
            ->where('name', 'Denver, CO')
            ->first();
    }
}
