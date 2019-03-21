<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment;

use Carbon\Carbon;
use TestCase;

class KentuckyUnemploymentTest extends TestCase
{
    private const EARNINGS = 167.00;
    private const TAX = 4.51;
    private const WAGE_BASE = 10500;
    private const ZERO = 0.0;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testKentuckyUnemployment(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
        });

        $this->assertThat(self::TAX, self::identicalTo($results->getTax(KentuckyUnemployment::class)));
    }

    public function testKentuckyUnemployment_earningsAndYtdEqualWageBase(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setYtdEarnings(self::WAGE_BASE - self::EARNINGS);
        });

        $this->assertThat(self::TAX, self::identicalTo($results->getTax(KentuckyUnemployment::class)));
    }

    public function testKentuckyUnemployment_earningsAndYtdExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS * 2);
            $taxes->setYtdEarnings(self::WAGE_BASE - self::EARNINGS);
        });

        $this->assertThat(self::TAX, self::identicalTo($results->getTax(KentuckyUnemployment::class)));
    }

    public function testKentuckyUnemployment_ytdEqualWageBase(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setYtdEarnings(self::WAGE_BASE);
        });

        $this->assertThat(self::ZERO, self::identicalTo($results->getTax(KentuckyUnemployment::class)));
    }

    public function testKentuckyUnemployment_ytdExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setYtdEarnings(self::WAGE_BASE + 1);
        });

        $this->assertThat(self::ZERO, self::identicalTo($results->getTax(KentuckyUnemployment::class)));
    }

    public function testKentuckyUnemployment_workOutOfState()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
        });

        $this->assertThat(self::TAX, self::identicalTo($results->getTax(KentuckyUnemployment::class)));
    }

    public function testKentuckyUnemployment_liveOutOfState()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
        });

        $this->assertNull($results->getTax(KentuckyUnemployment::class));
    }
}
