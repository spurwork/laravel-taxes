<?php

namespace Appleton\Taxes\Countries\US\Arizona\ArizonaUnemployment;

use Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\ArizonaIncome;
use Carbon\Carbon;

class ArizonaUnemploymentTest extends \TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testArizonaUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(ArizonaUnemployment::class));
    }

    public function testArizonaUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.arizona.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(ArizonaUnemployment::class));
    }

    public function testArizonaUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(6300);
        });

        $this->assertSame(2.00, $results->getTax(ArizonaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(6950);
        });

        $this->assertSame(1.00, $results->getTax(ArizonaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(7500);
        });

        $this->assertSame(null, $results->getTax(ArizonaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.arizona'));
            $taxes->setWorkLocation($this->getLocation('us.arizona'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(7550);
        });

        $this->assertSame(null, $results->getTax(ArizonaUnemployment::class));
    }
}
