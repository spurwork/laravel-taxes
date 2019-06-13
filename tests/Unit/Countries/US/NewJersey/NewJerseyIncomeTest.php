<?php

namespace Appleton\Taxes\Unit\Countries\US\NewJersey\NewJerseyIncome;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class NewJerseyIncomeTest extends TestCase
{
    public function testNewJerseyIncome()
    {
        NewJerseyIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'exempt' => false,
            'exemptions' => 0,
            'filing_status' => NewJerseyIncome::FILING_SINGLE,
        ]);

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.5, $results->getTax(NewJerseyIncome::class));
    }
}
