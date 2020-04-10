<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\TaxableWage;
use Appleton\Taxes\Classes\WorkerTaxes\TaxManager;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment;
use Carbon\Carbon;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @property TaxManager $tax_manager
 */
class TaxManagerTest extends TestCase
{
    private $tax_manager;
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tax_manager = app(TaxManager::class);
        $this->factory = Factory::create();
        Carbon::setTestNow('2020-02-15');
    }

    public function testComputeYtdTaxes(): void
    {
        $tax_amount_1 = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_2 = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(2),
            FederalIncome::class
        );
        $tax_amount_3 = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(3),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount_1, $tax_amount_2, $tax_amount_3]));

        $results = $this->tax_manager->computeYtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        $expected_amount = $tax_amount_1->getAmount() + $tax_amount_2->getAmount() + $tax_amount_3->getAmount();
        self::assertThat($results, self::equalTo($expected_amount / 100));
    }

    public function testComputeYtdTaxes_not_contain_tax(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount]));

        $results = $this->tax_manager->computeYtdTaxableWages($tax_amounts, FederalUnemployment::class, Carbon::now());

        self::assertThat($results, self::equalTo(0.0));
    }

    public function testComputeYtdTaxes_tax_before_year(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_before_year = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->startOfYear()->subDay(),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount, $tax_amount_before_year]));

        $results = $this->tax_manager->computeYtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        self::assertThat($results, self::equalTo($tax_amount->getAmount() / 100));
    }

    public function testComputeYtdTaxes_tax_after_date(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_after_date = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->addDay(),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount, $tax_amount_after_date]));

        $results = $this->tax_manager->computeYtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        self::assertThat($results, self::equalTo($tax_amount->getAmount() / 100));
    }

    public function testComputeYtdTaxes_other_tax(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_other_tax = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->addDay(),
            FederalUnemployment::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount]));
        $tax_amounts->put(FederalUnemployment::class, collect([$tax_amount_other_tax]));

        $results = $this->tax_manager->computeYtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        self::assertThat($results, self::equalTo($tax_amount->getAmount() / 100));
    }

    public function testComputeMtdTaxes(): void
    {
        $tax_amount_1 = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_2 = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(2),
            FederalIncome::class
        );
        $tax_amount_3 = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(3),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount_1, $tax_amount_2, $tax_amount_3]));

        $results = $this->tax_manager->computeMtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        $expected_amount = $tax_amount_1->getAmount() + $tax_amount_2->getAmount() + $tax_amount_3->getAmount();
        self::assertThat($results, self::equalTo($expected_amount / 100));
    }

    public function testComputeMtdTaxes_not_contain_tax(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount]));

        $results = $this->tax_manager->computeMtdTaxableWages($tax_amounts, FederalUnemployment::class, Carbon::now());

        self::assertThat($results, self::equalTo(0.0));
    }

    public function testComputeMtdTaxes_tax_before_month(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_before_year = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->startOfMonth()->subDay(),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount, $tax_amount_before_year]));

        $results = $this->tax_manager->computeMtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        self::assertThat($results, self::equalTo($tax_amount->getAmount() / 100));
    }

    public function testComputeMtdTaxes_tax_after_date(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_after_date = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->addDay(),
            FederalIncome::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount, $tax_amount_after_date]));

        $results = $this->tax_manager->computeMtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        self::assertThat($results, self::equalTo($tax_amount->getAmount() / 100));
    }

    public function testComputeMtdTaxes_other_tax(): void
    {
        $tax_amount = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->subDays(1),
            FederalIncome::class
        );
        $tax_amount_other_tax = new TaxableWage(
            $this->factory->numberBetween(100, 10000),
            Carbon::now()->addDay(),
            FederalUnemployment::class
        );

        $tax_amounts = collect([]);
        $tax_amounts->put(FederalIncome::class, collect([$tax_amount]));
        $tax_amounts->put(FederalUnemployment::class, collect([$tax_amount_other_tax]));

        $results = $this->tax_manager->computeMtdTaxableWages($tax_amounts, FederalIncome::class, Carbon::now());

        self::assertThat($results, self::equalTo($tax_amount->getAmount() / 100));
    }
}
