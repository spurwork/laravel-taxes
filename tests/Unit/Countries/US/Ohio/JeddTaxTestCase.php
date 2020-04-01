<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Carbon\Carbon;
use ReflectionClass;

class JeddTaxTestCase extends TaxTestCase
{
    protected function validate(TestParameters $parameters): void
    {
        Carbon::setTestNow($parameters->getDate());

        $home_location_array = $this->getLocation($parameters->getHomeLocation());
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        $wages = collect([
            $this->makeWageWithAdditionalTax($home_location, $parameters->getAdditionalTax(), $parameters->getWagesInCents()),
        ]);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            $home_location,
            $home_location,
            $wages,
            collect([]),
            collect([]),
            $this->user,
            $parameters->getBirthDate(),
            $parameters->getPayPeriods(),
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
            .' tax amount but got '.$result->getAmountInCents());
    }
}
