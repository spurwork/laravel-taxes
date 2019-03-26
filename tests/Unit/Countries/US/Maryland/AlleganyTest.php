<?php

namespace Appleton\Taxes\Countries\US\Maryland\Allegany\Allgeny;

use Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Carbon\Carbon;
use TestCase;

class AlleganyTest extends TestCase
{
    private const PAY_PERIODS = 52;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testAlleganyIncomeTax()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland.allegany'));
            $taxes->setWorkLocation($this->getLocation('us.maryland.allegany'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(3.37, self::identicalTo($results->getTax(MarylandIncome::class)));
        $this->assertThat(2.17, self::identicalTo($results->getTax(Allegany::class)));
    }
}
