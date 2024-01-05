<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Classes\WorkerTaxes\TaxesQueryRunner;
use Appleton\Taxes\Classes\WorkerTaxes\TaxOverrideManager;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;

/**
 * @property Taxes taxes
 */
abstract class TaxTestCase extends UnitTestCase
{
    protected TaxesQueryRunner $query_runner;
    protected Taxes $taxes;

    public function setUp(): void
    {
        parent::setUp();

        $this->query_runner = new TestTaxesQueryRunner();
        $this->app->instance(TaxesQueryRunner::class, $this->query_runner);
        $this->app->instance(TaxOverrideManager::class, new TaxOverrideManager($this->query_runner));
        $this->taxes = app(Taxes::class);
    }

    protected function disableTestQueryRunner(): void
    {
        $this->app->forgetInstance(TaxesQueryRunner::class);
        $this->app->forgetInstance(TaxOverrideManager::class);
        $this->taxes = app(Taxes::class);
    }

    /**
     * @throws ReflectionException
     */
    protected function validate(TestParameters $parameters): void
    {
        Carbon::setTestNow($parameters->getDate());

        if (!empty($parameters->getTaxInfoOptions())) {
            $parameters->getTaxInfoClass()::forUser($this->user)->update($parameters->getTaxInfoOptions());
        }

        $home_location_array = $this->getLocation($parameters->getHomeLocation());
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        if ($parameters->getWorkLocation() === null) {
            $work_location = $home_location;
        } else {
            $work_location_array = $this->getLocation($parameters->getWorkLocation());
            $work_location = new GeoPoint($work_location_array[0], $work_location_array[1]);
        }

        $wages = collect([]);

        if ($parameters->getWagesCallback() !== null) {
            call_user_func($parameters->getWagesCallback(), $parameters, $wages);
        } else {
            $wages->push($this->makeWage(
                $work_location,
                $parameters->getWagesInCents(),
                $parameters->getPaycheckTipAmountInCents(),
                $parameters->getTakeHomeTipAmountInCents(),
                $parameters->getMinutesWorked(),
            ));
        }

        if (!empty($parameters->getOvertimeWagesInCents())) {
            $wages->push($this->makeWage(
                $work_location,
                $parameters->getOvertimeWagesInCents(),
                $parameters->getPaycheckTipAmountInCents(),
                $parameters->getTakeHomeTipAmountInCents(),
                $parameters->getMinutesWorked(),
                UnitTestCase::DEFAULT_POSITION,
                true,
            ));
        }

        if ($parameters->getSupplementalWagesInCents() !== null
        && $parameters->getSupplementalWagesInCents() !== 0) {
            $wages->push($this->makeSupplementalWage($work_location, $parameters->getSupplementalWagesInCents()));
        }

        $annual_wages = collect([]);
        if ($parameters->getYtdWagesInCents() !== null
        && $parameters->getYtdWagesInCents() !== 0) {
            $annual_wages->push($this->makeWage($work_location, $parameters->getYtdWagesInCents()));
        } elseif ($parameters->getMtdWagesInCents() !== null
        && $parameters->getMtdWagesInCents() !== 0) {
            $annual_wages->push($this->makeWage($work_location, $parameters->getMtdWagesInCents()));
        } elseif ($parameters->getWtdWagesInCents() !== null
        && $parameters->getWtdWagesInCents() !== 0) {
            $annual_wages->push($this->makeWage($work_location, $parameters->getWtdWagesInCents()));
        }

        $annual_taxable_wages = collect([]);
        if ($parameters->getYtdLiabilitiesInCents() !== null
        && $parameters->getYtdLiabilitiesInCents() !== 0) {
            $taxable_wage = $this->makeTaxableWage($parameters->getTaxClass(), $parameters->getYtdLiabilitiesInCents());

            $annual_taxable_wages->put($parameters->getTaxClass(), collect([$taxable_wage]));
        } elseif ($parameters->getMtdLiabilitiesInCents() !== null
        && $parameters->getMtdLiabilitiesInCents() !== 0) {
            $taxable_wage = $this->makeTaxableWageAtDate(
                now(),
                $parameters->getTaxClass(),
                $parameters->getMtdLiabilitiesInCents(),
            );

            $annual_taxable_wages->put($parameters->getTaxClass(), collect([$taxable_wage]));
        }

        $annual_liability_amounts = collect([]);
        if ($parameters->getYtdLiabilitiesInCents() !== null
        && $parameters->getYtdLiabilitiesInCents() !== 0) {
            $taxable_wage = $this->makeLiabilityAmount(
                $parameters->getTaxClass(),
                $parameters->getYtdLiabilitiesInCents(),
            );

            $annual_liability_amounts->put($parameters->getTaxClass(), collect([$taxable_wage]));
        } elseif ($parameters->getMtdLiabilitiesInCents() !== null
        && $parameters->getMtdLiabilitiesInCents() !== 0) {
            $taxable_wage = $this->makeLiabilityAmountAtDate(
                now(),
                $parameters->getTaxClass(),
                $parameters->getMtdLiabilitiesInCents(),
            );

            $annual_liability_amounts->put($parameters->getTaxClass(), collect([$taxable_wage]));
        }

        $pay_periods_exempt = $parameters->getPayPeriodsCount() !== null ? $parameters->getPayPeriodsCount() : 0;

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            $wages,
            $annual_wages,
            $annual_taxable_wages,
            $annual_liability_amounts,
            $this->user,
            $parameters->getBirthDate(),
            $parameters->getPayPeriods(),
            collect([]),
            collect([]),
            collect([]),
            $pay_periods_exempt,
            $parameters->getWorkersCompRates(),
            $parameters->getSutaRates()
        );

        $short_name = (new ReflectionClass($parameters->getTaxClass()))->getShortName();

        /** @var TaxResult $result */
        $result = $results->get($parameters->getTaxClass());
        if ($result === null) {
            self::fail('no tax results for '.$short_name.' found');
        }

        if ($result instanceof Collection) {
            $the_results = $result;

            $i = 0;
            $the_results->each(function (TaxResult $result) use ($short_name, $parameters, &$i) {
                self::assertThat(
                    $result->getAmountInCents(),
                    self::identicalTo($parameters->getExpectedAmountsInCents()[$i]),
                    $short_name.' expected '.$parameters->getExpectedAmountsInCents()[$i]
                    .' tax amount but got '.$result->getAmountInCents()
                );

                if ($parameters->getExpectedEarningsInCents() === null) {
                    self::assertThat(
                        $result->getEarningsInCents(),
                        self::identicalTo($parameters->getWagesInCents()),
                        $short_name.' expected '.$parameters->getWagesInCents()
                        .' earnings but got '.$result->getEarningsInCents()
                    );
                } else {
                    self::assertThat(
                        $result->getEarningsInCents(),
                        self::identicalTo($parameters->getExpectedEarningsInCents()),
                        $short_name.' expected '.$parameters->getExpectedEarningsInCents()
                        .' earnings but got '.$result->getEarningsInCents()
                    );
                }
                ++$i;
            });
        } else {
            self::assertThat(
                $result->getAmountInCents(),
                self::identicalTo($parameters->getExpectedAmountInCents()),
                $short_name.' expected '.$parameters->getExpectedAmountInCents()
                .' tax amount but got '.$result->getAmountInCents()
            );

            if ($parameters->getExpectedEarningsInCents() === null) {
                self::assertThat(
                    $result->getEarningsInCents(),
                    self::identicalTo($parameters->getWagesInCents()),
                    $short_name.' expected '.$parameters->getWagesInCents()
                    .' earnings but got '.$result->getEarningsInCents()
                );
            } else {
                self::assertThat(
                    $result->getEarningsInCents(),
                    self::identicalTo($parameters->getExpectedEarningsInCents()),
                    $short_name.' expected '.$parameters->getExpectedEarningsInCents()
                    .' earnings but got '.$result->getEarningsInCents()
                );
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    public function validateNoTax(TestParameters $parameters): void
    {
        Carbon::setTestNow($parameters->getDate());

        if (!empty($parameters->getTaxInfoOptions())) {
            $parameters->getTaxInfoClass()::forUser($this->user)->update($parameters->getTaxInfoOptions());
        }

        $home_location_array = $this->getLocation($parameters->getHomeLocation());
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        if ($parameters->getWorkLocation() === null) {
            $work_location = $home_location;
        } else {
            $work_location_array = $this->getLocation($parameters->getWorkLocation());
            $work_location = new GeoPoint($work_location_array[0], $work_location_array[1]);
        }

        $wages = collect([
            $this->makeWage($work_location, $parameters->getWagesInCents()),
        ]);

        if ($parameters->getSupplementalWagesInCents() !== null
            && $parameters->getSupplementalWagesInCents() !== 0) {
            $wages->push($this->makeSupplementalWage($work_location, $parameters->getSupplementalWagesInCents()));
        }

        $historical_wages = collect([]);
        if ($parameters->getYtdWagesInCents() !== null
            && $parameters->getYtdWagesInCents() !== 0) {
            $historical_wages->push($this->makeWage($work_location, $parameters->getYtdWagesInCents()));
        } elseif ($parameters->getWtdWagesInCents() !== null
            && $parameters->getWtdWagesInCents() !== 0) {
            $historical_wages->push($this->makeWage($work_location, $parameters->getWtdWagesInCents()));
        }

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            $wages,
            $historical_wages,
            collect([]),
            collect([]),
            $this->user,
            $parameters->getBirthDate(),
            $parameters->getPayPeriods(),
            collect([]),
            collect([]),
            collect([]),
            0,
            $parameters->getWorkersCompRates(),
            $parameters->getSutaRates()
        );

        $short_name = (new ReflectionClass($parameters->getTaxClass()))->getShortName();
        if ($results->get($parameters->getTaxClass()) !== null) {
            self::fail('tax results for '.$short_name.' found but not expected');
        } else {
            $this->addToAssertionCount(1);
        }
    }
}
