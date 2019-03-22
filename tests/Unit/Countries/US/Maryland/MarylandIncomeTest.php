<?php

namespace Appleton\Taxes\Unit\Countries\US\Maryland;

use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Carbon\Carbon;
use TestCase;

class MarylandIncomeTest extends TestCase
{
    private const PAY_PERIODS = 52;
    private const EARNINGS = 166.68;
    private const TAX_AMOUNT = 5.84;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMarylandIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(self::TAX_AMOUNT, self::identicalTo($results->getTax(MarylandIncome::class)));
    }
}