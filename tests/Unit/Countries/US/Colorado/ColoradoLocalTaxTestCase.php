<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\TestModelCreator;
use Carbon\Carbon;
use ReflectionClass;

class ColoradoLocalTaxTestCase extends TaxTestCase
{
    use TestModelCreator;

    public function validateColoradoLocal(ColoradoLocalIncomeParameters $parameters): void
    {
        Carbon::setTestNow($parameters->getDate());

        $colorado_location_array = $this->getLocation('us.colorado');
        $local_location_array = $this->getLocation($parameters->getLocalLocation());

        $colorado_location = new GeoPoint($colorado_location_array[0], $colorado_location_array[1]);
        $local_location = new GeoPoint($local_location_array[0], $local_location_array[1]);

        $wages = collect([
            $this->makeWage($colorado_location, $parameters->getColoradoEarningsInCents()),
            $this->makeWage($local_location, $parameters->getLocalEarningsInCents()),
        ]);

        $annual_wages = collect([
            $this->makeWageAtDate(Carbon::now()->subWeek(), $local_location, $parameters->getLocalMtdEarningsInCents()),
        ]);

        $annual_taxable_wages = collect([]);
        $annual_taxable_wages->put(ColoradoIncome::class, collect([
            $this->makeTaxableWageAtDate(now()->addWeek(), ColoradoIncome::class, $parameters->getColoradoMtdLiabilitiesInCents())
        ]));

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $local_location,
            $local_location,
            $wages,
            $annual_wages,
            $annual_taxable_wages,
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([])
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
            self::identicalTo($parameters->getColoradoEarningsInCents() + $parameters->getLocalEarningsInCents()),
            $short_name.' expected '.($parameters->getColoradoEarningsInCents() + $parameters->getLocalEarningsInCents())
            .' earnings but got '.$result->getEarningsInCents()
        );
    }

    public function validateColoradoLocalNoTax(ColoradoLocalIncomeParameters $parameters): void
    {
        Carbon::setTestNow($parameters->getDate());

        $colorado_location_array = $this->getLocation('us.colorado');
        $local_location_array = $this->getLocation($parameters->getLocalLocation());

        $colorado_location = new GeoPoint($colorado_location_array[0], $colorado_location_array[1]);
        $local_location = new GeoPoint($local_location_array[0], $local_location_array[1]);

        $wages = collect([
            $this->makeWage($colorado_location, $parameters->getColoradoEarningsInCents()),
            $this->makeWage($local_location, $parameters->getLocalEarningsInCents()),
        ]);

        $past_date = Carbon::now()->subWeek();

        $historical_wages = collect([
            $this->makeWageAtDate($past_date, $colorado_location, $parameters->getColoradoMtdLiabilitiesInCents()),
            $this->makeWageAtDate($past_date, $local_location, $parameters->getLocalMtdEarningsInCents()),
        ]);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $local_location,
            $local_location,
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

        $short_name = (new ReflectionClass($parameters->getTaxClass()))->getShortName();
        if ($results->get($parameters->getTaxClass()) !== null) {
            self::fail('tax results for '.$short_name.' found but not expected');
        } else {
            $this->addToAssertionCount(1);
        }
    }

    public function standardColoradoLocalTestCases(
        string $date,
        string $local_location,
        string $tax_class,
        float $wage_amount_in_dollars,
        float $tax_amount
    ): array {
        $builder = new ColoradoLocalIncomeParametersBuilder();
        $builder
            ->setDate($date)
            ->setLocalLocation($local_location)
            ->setTaxClass($tax_class);

        return [
            'local under' => [
                $builder
                    ->setLocalEarningsInCents($wage_amount_in_dollars - 1)
                    ->setLocalMtdEarningsInCents(0)
                    ->setColoradoEarningsInCents(0)
                    ->setColoradoMtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            // 'local equal' => [
            //     $builder
            //         ->setLocalEarningsInCents($wage_amount_in_dollars)
            //         ->setLocalMtdLiabilitiesInCents(0)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'local over' => [
            //     $builder
            //         ->setLocalEarningsInCents($wage_amount_in_dollars + 1)
            //         ->setLocalMtdLiabilitiesInCents(0)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'local mtd under' => [
            //     $builder
            //         ->setLocalEarningsInCents(1)
            //         ->setLocalMtdLiabilitiesInCents($wage_amount_in_dollars - 2)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'local mtd equal' => [
            //     $builder
            //         ->setLocalEarningsInCents(1)
            //         ->setLocalMtdLiabilitiesInCents($wage_amount_in_dollars - 1)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'local mtd over' => [
            //     $builder
            //         ->setLocalEarningsInCents(1)
            //         ->setLocalMtdLiabilitiesInCents($wage_amount_in_dollars)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'local both under' => [
            //     $builder
            //         ->setLocalEarningsInCents(100)
            //         ->setLocalMtdLiabilitiesInCents($wage_amount_in_dollars - 100 - 1)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'local both equal' => [
            //     $builder
            //         ->setLocalEarningsInCents(100)
            //         ->setLocalMtdLiabilitiesInCents($wage_amount_in_dollars - 100)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'local both over' => [
            //     $builder
            //         ->setLocalEarningsInCents(100)
            //         ->setLocalMtdLiabilitiesInCents($wage_amount_in_dollars - 100 + 1)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'co under' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents($wage_amount_in_dollars - 2)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'co equal' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents($wage_amount_in_dollars - 1)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'co over' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents($wage_amount_in_dollars)
            //         ->setColoradoMtdLiabilitiesInCents(0)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            'co mtd under' => [
                $builder
                    ->setLocalEarningsInCents(0)
                    ->setLocalMtdEarningsInCents(1)
                    ->setColoradoEarningsInCents(0)
                    ->setColoradoMtdLiabilitiesInCents($wage_amount_in_dollars - 2)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            // 'co mtd equal' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents($wage_amount_in_dollars - 1)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'co mtd over' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents(0)
            //         ->setColoradoMtdLiabilitiesInCents($wage_amount_in_dollars)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'co both under' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents(100)
            //         ->setColoradoMtdLiabilitiesInCents($wage_amount_in_dollars - 100 - 2)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'co both equal' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents(100)
            //         ->setColoradoMtdLiabilitiesInCents($wage_amount_in_dollars - 100 - 1)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'co both over' => [
            //     $builder
            //         ->setLocalEarningsInCents(0)
            //         ->setLocalMtdLiabilitiesInCents(1)
            //         ->setColoradoEarningsInCents(100)
            //         ->setColoradoMtdLiabilitiesInCents($wage_amount_in_dollars - 100)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'all under' => [
            //     $builder
            //         ->setLocalEarningsInCents($wage_amount_in_dollars - 300 - 1)
            //         ->setLocalMtdLiabilitiesInCents(100)
            //         ->setColoradoEarningsInCents(100)
            //         ->setColoradoMtdLiabilitiesInCents(100)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'all equal' => [
            //     $builder
            //         ->setLocalEarningsInCents($wage_amount_in_dollars - 300)
            //         ->setLocalMtdLiabilitiesInCents(100)
            //         ->setColoradoEarningsInCents(100)
            //         ->setColoradoMtdLiabilitiesInCents(100)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
            // 'all over' => [
            //     $builder
            //         ->setLocalEarningsInCents($wage_amount_in_dollars - 300 + 1)
            //         ->setLocalMtdLiabilitiesInCents(100)
            //         ->setColoradoEarningsInCents(100)
            //         ->setColoradoMtdLiabilitiesInCents(100)
            //         ->setExpectedAmountInCents($tax_amount)
            //         ->build()
            // ],
        ];
    }
}
