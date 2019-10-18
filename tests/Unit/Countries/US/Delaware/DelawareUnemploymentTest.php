<?php

namespace Appleton\Taxes\Unit\Countries\US\Delaware;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Delaware\DelawareUnemployment\DelawareUnemployment;
use Carbon\Carbon;
use TestCase;

class DelawareUnemploymentTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
		Carbon::setTestNow(Carbon::parse('2019-01-01'));
	}
}
