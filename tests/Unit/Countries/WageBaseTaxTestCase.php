<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Carbon\Carbon;
use ReflectionClass;

/**
 * @property Taxes taxes
 */
class WageBaseTaxTestCase extends TaxTestCase
{
    protected function validateWageBase(TestParameters $parameters): void
    {
        Carbon::setTestNow($parameters->getDate());

        if ($parameters->getTaxRate() !== null) {
            config($parameters->getTaxRate());
        }

        $home_location_array = self::getLocation($parameters->getHomeLocation());
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        if ($parameters->getWorkLocation() === null) {
            $work_location = $home_location;
        } else {
            $work_location_array = self::getLocation($parameters->getWorkLocation());
            $work_location = new GeoPoint($work_location_array[0], $work_location_array[1]);
        }

        $wages = collect([
            $this->makeWage($work_location, $parameters->getWagesInCents()),
        ]);

        $annual_wages = collect([]);
        if ($parameters->getYtdWagesInCents() !== null
            && $parameters->getYtdWagesInCents() !== 0) {
            $annual_wages->push($this->makeWage($work_location, $parameters->getYtdWagesInCents()));
        }

        $annual_taxable_wages = collect([]);
        if ($parameters->getYtdLiabilitiesInCents() !== null
            && $parameters->getYtdLiabilitiesInCents() !== 0) {
            $taxable_wage = $this->makeTaxableWage($parameters->getTaxClass(), $parameters->getYtdLiabilitiesInCents());

            $annual_taxable_wages->put($parameters->getTaxClass(), collect([$taxable_wage]));
        }

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            $wages,
            $annual_wages,
            $annual_taxable_wages,
            collect([]),
            $this->user,
            null,
            1,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            $parameters->getSutaRates()
        );

        $short_name = (new ReflectionClass($parameters->getTaxClass()))->getShortName();

        /** @var TaxResult $result */
        $result = $results->get($parameters->getTaxClass());
        if ($result === null) {
            self::fail('no tax results for '.$short_name.' found');
        }

        self::assertThat(
            $result->getAmountInCents(),
            self::identicalTo($parameters->getExpectedAmountInCents()),
            $short_name.' expected '.$parameters->getExpectedAmountInCents()
            .' tax amount but got '.$result->getAmountInCents()
        );

        self::assertThat(
            $result->getEarningsInCents(),
            self::identicalTo($parameters->getExpectedEarningsInCents()),
            $short_name.' expected '.$parameters->getExpectedEarningsInCents()
            .' earnings but got '.$result->getEarningsInCents()
        );
    }

    protected static function wageBaseBoundariesTestCases(
        string $date,
        string $home_location,
        string $tax_class,
        int $wage_base_in_cents,
        float $tax_rate,
    ): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate($date)
            ->setHomeLocation($home_location)
            ->setTaxClass($tax_class);

        if (defined("{$tax_class}::STATE")) {
            $builder->addSutaRate($tax_class::STATE, $tax_rate);
        }

        return [
            'current wages not meet wage base' => [
                $builder
                    ->setWagesInCents($wage_base_in_cents - 1000)
                    ->setYtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(self::calculate($wage_base_in_cents - 1000, $tax_rate))
                    ->setExpectedEarningsInCents($wage_base_in_cents - 1000)
                    ->build()
            ],
            'current wages meet wage base' => [
                $builder
                    ->setWagesInCents($wage_base_in_cents)
                    ->setYtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(self::calculate($wage_base_in_cents, $tax_rate))
                    ->setExpectedEarningsInCents($wage_base_in_cents)
                    ->build()
            ],
            'current wages exceed wage base' => [
                $builder
                    ->setWagesInCents($wage_base_in_cents + 1000)
                    ->setYtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(self::calculate($wage_base_in_cents, $tax_rate))
                    ->setExpectedEarningsInCents($wage_base_in_cents)
                    ->build()
            ],
            'total wages not meet wage base' => [
                $builder
                    ->setWagesInCents(1000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents - 2000)
                    ->setExpectedAmountInCents(self::calculate(1000, $tax_rate))
                    ->setExpectedEarningsInCents(1000)
                    ->build()
            ],
            'total wages meet wage base' => [
                $builder
                    ->setWagesInCents(1000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents - 1000)
                    ->setExpectedAmountInCents(self::calculate(1000, $tax_rate))
                    ->setExpectedEarningsInCents(1000)
                    ->build()
            ],
            'total wages cross wage base' => [
                $builder
                    ->setWagesInCents(2000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents - 1000)
                    ->setExpectedAmountInCents(self::calculate(1000, $tax_rate))
                    ->setExpectedEarningsInCents(1000)
                    ->build()
            ],
            'ytd wages meet wage base' => [
                $builder
                    ->setWagesInCents(1000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
            'ytd wages exceed wage base' => [
                $builder
                    ->setWagesInCents(1000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents + 1000)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
        ];
    }

    protected static function roundedWageBaseBoundariesTestCases(
        string $date,
        string $home_location,
        string $tax_class,
        int $wage_base_in_cents,
        float $tax_rate,
    ): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate($date)
            ->setHomeLocation($home_location)
            ->setTaxClass($tax_class);

        if (defined("{$tax_class}::STATE")) {
            $builder->addSutaRate($tax_class::STATE, $tax_rate);
        }

        return [
            'current wages not meet wage base' => [
                $builder
                    ->setWagesInCents($wage_base_in_cents - 10000)
                    ->setYtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(self::roundToDollar(self::calculate($wage_base_in_cents - 10000, $tax_rate)))
                    ->setExpectedEarningsInCents($wage_base_in_cents - 10000)
                    ->build()
            ],
            'current wages meet wage base' => [
                $builder
                    ->setWagesInCents($wage_base_in_cents)
                    ->setYtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(self::roundToDollar(self::calculate($wage_base_in_cents, $tax_rate)))
                    ->setExpectedEarningsInCents($wage_base_in_cents)
                    ->build()
            ],
            'current wages exceed wage base' => [
                $builder
                    ->setWagesInCents($wage_base_in_cents + 10000)
                    ->setYtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(self::roundToDollar(self::calculate($wage_base_in_cents, $tax_rate)))
                    ->setExpectedEarningsInCents($wage_base_in_cents)
                    ->build()
            ],
            'total wages not meet wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents - 20000)
                    ->setExpectedAmountInCents(self::roundToDollar(self::calculate(10000, $tax_rate)))
                    ->setExpectedEarningsInCents(10000)
                    ->build()
            ],
            'total wages meet wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents - 10000)
                    ->setExpectedAmountInCents(self::roundToDollar(self::calculate(10000, $tax_rate)))
                    ->setExpectedEarningsInCents(10000)
                    ->build()
            ],
            'total wages cross wage base' => [
                $builder
                    ->setWagesInCents(20000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents - 10000)
                    ->setExpectedAmountInCents(self::roundToDollar(self::calculate(10000, $tax_rate)))
                    ->setExpectedEarningsInCents(10000)
                    ->build()
            ],
            'ytd wages meet wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
            'ytd wages exceed wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdLiabilitiesInCents($wage_base_in_cents + 10000)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
        ];
    }

    protected static function calculate($amount, $tax_rate)
    {
        return bcmul(round(($amount / 100) * $tax_rate, 2), 100);
    }

    protected static function roundToDollar(int $cents)
    {
        return round($cents, -2);
    }
}
