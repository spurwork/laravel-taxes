<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Arkansas\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome;
use Appleton\Taxes\Models\Countries\US\Arkansas\ArkansasIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Carbon\Carbon;
use ReflectionClass;

class ArkansasIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION_ARKANSAS = 'us.arkansas';
    private const LOCATION_ARKANSAS_TEXARKANA = 'us.arkansas.texarkana';
    private const LOCATION_TEXAS = 'us.texas';
    private const LOCATION_TEXAS_TEXARKANA = 'us.texas.texarkana';
    private const TAX_CLASS = ArkansasIncome::class;
    private const TAX_INFO_CLASS = ArkansasIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        ArkansasIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideTexarkanaTestData
     */
    public function testTax_texarkana(TestParameters $parameters): void
    {
        $this->disableTestQueryRunner();
        $this->validate($parameters);
    }

    public function testTax_texarkana_wages_removed(): void
    {
        $this->disableTestQueryRunner();

        Carbon::setTestNow(self::DATE);

        $home_location_array = $this->getLocation(self::LOCATION_TEXAS_TEXARKANA);
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        $texarkana_arkansas_location_array = $this->getLocation(self::LOCATION_ARKANSAS_TEXARKANA);
        $texarkana_arkansas_location = new GeoPoint($texarkana_arkansas_location_array[0], $texarkana_arkansas_location_array[1]);

        $arkansas_location_array = $this->getLocation(self::LOCATION_ARKANSAS);
        $arkansas_location = new GeoPoint($arkansas_location_array[0], $arkansas_location_array[1]);

        $wages = collect([
            $this->makeWage($arkansas_location, 10000),
            $this->makeWage($texarkana_arkansas_location, 10000),
        ]);

        $historical_wages = collect([]);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            $wages,
            $historical_wages,
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([])
        );

        $short_name = (new ReflectionClass(ArkansasIncome::class))->getShortName();

        /** @var TaxResult $result */
        $result = $results->get(ArkansasIncome::class);

        self::assertNotNull($result, 'no tax results for '.$short_name.' found');
        self::assertThat(
            $result->getAmountInCents(),
            self::identicalTo(0),
            $short_name.' expected 0 tax amount but got '.$result->getAmountInCents()
        );
    }

    public function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION_ARKANSAS)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            'test case 1' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(3962)
                    ->build()
            ],
            'test case 2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 3,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(3812)
                    ->build()
            ],
            'bracket 1' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(7500)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'bracket 2' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(17500)
                    ->setExpectedAmountInCents(90)
                    ->build()
            ],
            'bracket 3' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(27500)
                    ->setExpectedAmountInCents(349)
                    ->build()
            ],
            'bracket 4' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(762)
                    ->build()
            ],
            'bracket 5' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2482)
                    ->build()
            ],
            'bracket 6' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4189)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(4962)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => true,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }

    public function provideTexarkanaTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            '01' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setWorkLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2732)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setWorkLocation(self::LOCATION_ARKANSAS)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2732)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS)
                    ->setWorkLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2732)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setHomeLocation(self::LOCATION_TEXAS_TEXARKANA)
                    ->setWorkLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setHomeLocation(self::LOCATION_TEXAS)
                    ->setWorkLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2732)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setWorkLocation(self::LOCATION_TEXAS)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2732)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setWorkLocation(self::LOCATION_TEXAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2732)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS_TEXARKANA)
                    ->setWorkLocation(self::LOCATION_TEXAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => true])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS)
                    ->setWorkLocation(self::LOCATION_TEXAS)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setHomeLocation(self::LOCATION_ARKANSAS)
                    ->setWorkLocation(self::LOCATION_TEXAS_TEXARKANA)
                    ->setTaxInfoOptions(['ar_tx_exempt' => false])
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
