<?php


namespace Appleton\Taxes\Unit\Countries\US\NewJersey;


use Appleton\Taxes\Countries\US\NewJersey\NewarkPayroll\NewarkPayroll;
use Carbon\Carbon;

class NewarkPayrollTest extends \TestCase
{
    public function testNewJerseyDisabilityInsurance()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey.newark'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(745);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.45, $results->getTax(NewarkPayroll::class));
    }
}