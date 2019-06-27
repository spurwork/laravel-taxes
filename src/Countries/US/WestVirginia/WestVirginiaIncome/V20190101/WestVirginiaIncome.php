<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\WestVirginiaIncome as BaseWestVirginiaIncome;

class WestVirginiaIncome extends BaseWestVirginiaIncome
{
    private const EXEMPTION_ALLOWANCE = 2000;

    private const ONE_EARNER_BRACKETS = [
        [0, .03, 0],
        [10000, .04, 300],
        [25000, .045, 900],
        [40000, .06, 1575],
        [60000, .065, 2775],
    ];

    private const TWO_EARNER_BRACKETS = [
        [0, .03, 0],
        [6000, .04, 180],
        [15000, .045, 540],
        [24000, .06, 945],
        [36000, .065, 1665],
    ];

    private const SUPPLEMENTAL_BRACKETS = [
        [0, .03],
        [10000, .04],
        [25000, .045],
        [40000, .06],
        [60000, .065],
    ];

    protected function getOneEarnerBrackets(): array
    {
        return self::ONE_EARNER_BRACKETS;
    }

    protected function getTwoEarnerBrackets(): array
    {
        return self::TWO_EARNER_BRACKETS;
    }

    protected function getExemptionsAllowance(): int
    {
        return self::EXEMPTION_ALLOWANCE;
    }

    protected function getSupplementalBrackets(): array
    {
        return self::SUPPLEMENTAL_BRACKETS;
    }
}
