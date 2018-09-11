<?php

namespace Appleton\Taxes\Countries\US\Arizona\ArizonaIncome;

use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;
use Carbon\Carbon;

class ArizonaIncomeTest extends \TestCase
{
    public function testArizonaIncome()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        ArizonaIncomeTaxInformation::forUser($this->user)->update(['percentage_withheld' => 1.3]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.26, $results->getTax(ArizonaIncome::class));

        ArizonaIncomeTaxInformation::forUser($this->user)->update(['percentage_withheld' => 4.2]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.07, $results->getTax(ArizonaIncome::class));
    }
}
