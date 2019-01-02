<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome;

use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Carbon\Carbon;

class NewMexicoIncome2018Test extends \TestCase
{
    public function testNewMexicoIncomeWorkerA()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerA();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(270);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(7340.50);
        });

        $this->assertSame(4.77, $results->getTax(NewMexicoIncome::class));
    }

    public function testNewMexicoIncomeWorkerB()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerB();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(785);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(17845);
        });

        $this->assertSame(17.87, $results->getTax(NewMexicoIncome::class));
    }

    public function testNewMexicoIncome2019WorkerC()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerC();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(160.80);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(255);
        });

        $this->assertSame(0.0, $results->getTax(NewMexicoIncome::class));
    }

    public function testNewMexicoIncome2019WorkerD()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerD();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(365);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(10432.12);
        });

        $this->assertSame(2.44, $results->getTax(NewMexicoIncome::class));
    }
    public function testNewMexicoIncome2019WorkerE()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerE();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(365);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(10432.12);
        });

        $this->assertSame(2.44, $results->getTax(NewMexicoIncome::class));
    }

    public function testNewMexicoIncome2019WorkerF()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerF();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(365);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(10432.12);
        });

        $this->assertSame(2.44, $results->getTax(NewMexicoIncome::class));
    }

    public function testNewMexicoIncome2019WorkerG()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $user = $this->createWorkerG();

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(365);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(10432.12);
        });

//        $this->assertSame(2.44, $results->getTax(NewMexicoIncome::class));
    }



    public function testNewMexicoSingleBracketBreakdown()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        // Single

        // 0 => 1.7
        // 5,500 -> 11k = 3.2 plus 93
        // 11k - 16k = 4.7 plus 269.50
        // 16k  = 4.9 plus 504.50


        $user = $this->emptyWorker();

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $user);

        $results = $this->taxes->calculate(function ($taxes) use ($user) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($user);
            $taxes->setEarnings(5400);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(0);
        });

        $this->assertSame(255.73, $results->getTax(NewMexicoIncome::class));
    }

    // 427.06


}
