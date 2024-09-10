<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\BindManager;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\TaxableIncome;
use Appleton\Taxes\Classes\WorkerTaxes\TaxManager;
use Appleton\Taxes\Classes\WorkerTaxes\WageManager;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20170101\AlabamaIncome as AlabamaIncome2017;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20180101\AlabamaIncome as AlabamaIncome2018;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20230101\AlabamaIncome as AlabamaIncome2023;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\FederalIncome\V20170101\FederalIncome as FederalIncome2017;
use Appleton\Taxes\Countries\US\FederalIncome\V20180101\FederalIncome as FederalIncome2018;
use Appleton\Taxes\Countries\US\FederalIncome\V20190101\FederalIncome as FederalIncome2019;
use Appleton\Taxes\Countries\US\FederalIncome\V20200101\FederalIncome as FederalIncome2020;
use Appleton\Taxes\Countries\US\FederalIncome\V20210101\FederalIncome as FederalIncome2021;
use Appleton\Taxes\Countries\US\FederalIncome\V20230101\FederalIncome as FederalIncome2023;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20180101\GeorgiaIncome as GeorgiaIncome2018;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20190101\GeorgiaIncome as GeorgiaIncome2019;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20230101\GeorgiaIncome as GeorgiaIncome2023;
use Appleton\Taxes\Models\Tax;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Carbon\Carbon;

class BindManagerTest extends TaxTestCase
{
    /** @dataProvider provideData */
    public function testImplementations(int $year, string $base_class, string $class): void
    {
        $bind_manager = app(BindManager::class);
        $bind_manager->bindPayroll(
            new Payroll(
                [
                    'name' => 'Test Payroll',
                    'start_date' => Carbon::parse("$year-01-01"),
                    'pay_date' => Carbon::parse("$year-10-01"),
                    'user' => $this->user,
                ],
                app(WageManager::class),
                app(TaxManager::class),
            ),
        );

        $tax = new Tax();
        $tax->class = $base_class;

        $bind_manager->bindTaxes(collect([new TaxableIncome($tax, collect(), collect(), 0)]));

        self::assertThat(app($base_class)::class, self::identicalTo($class));
    }

    public static function provideData(): array
    {
        return [
            'alabama_2017' => [2017, AlabamaIncome::class, AlabamaIncome2017::class],
            'alabama_2018' => [2018, AlabamaIncome::class, AlabamaIncome2018::class],
            'alabama_2019' => [2019, AlabamaIncome::class, AlabamaIncome2018::class],
            'alabama_2023' => [2023, AlabamaIncome::class, AlabamaIncome2023::class],
            'federal_2017' => [2017, FederalIncome::class, FederalIncome2017::class],
            'federal_2018' => [2018, FederalIncome::class, FederalIncome2018::class],
            'federal_2019' => [2019, FederalIncome::class, FederalIncome2019::class],
            'federal_2020' => [2020, FederalIncome::class, FederalIncome2020::class],
            'federal_2021' => [2021, FederalIncome::class, FederalIncome2021::class],
            'federal_2022' => [2022, FederalIncome::class, FederalIncome2021::class],
            'federal_2023' => [2023, FederalIncome::class, FederalIncome2023::class],
            'georgia_2018' => [2018, GeorgiaIncome::class, GeorgiaIncome2018::class],
            'georgia_2019' => [2019, GeorgiaIncome::class, GeorgiaIncome2019::class],
            'georgia_2020' => [2020, GeorgiaIncome::class, GeorgiaIncome2019::class],
            'georgia_2023' => [2023, GeorgiaIncome::class, GeorgiaIncome2023::class],
        ];
    }
}
