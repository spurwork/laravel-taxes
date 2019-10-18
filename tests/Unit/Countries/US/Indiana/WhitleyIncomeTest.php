<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\WhitleyIncome\WhitleyIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class WhitleyIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
    * @dataProvider provideTestData
    */
    public function testWhitleyIncome($date, $result): void
    {
        Carbon::setTestNow(Carbon::parse($date));

        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 92,
            'county_worked' => 91,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.whitley'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.whitley'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat($result, self::identicalTo($results->getTax(WhitleyIncome::class)));
    }

    public function testWhitleyIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 92,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.whitley'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.whitley'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(4.44, self::identicalTo($results->getTax(WhitleyIncome::class)));
    }

    public function provideTestData(): array
    {
        return [
            '2019-01-01' => ['2019-01-01', 4.44],
            '2019-10-01' => ['2019-10-01', 5.04],
        ];
    }
}
