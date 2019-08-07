<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\AuroraOccupationalPrivilege as BaseAuroraOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class AuroraOccupationalPrivilege extends BaseAuroraOccupationalPrivilege
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
            ->where('name', 'Aurora, CO')
            ->first();
    }
}
