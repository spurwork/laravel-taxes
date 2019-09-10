<?php

namespace Appleton\Taxes\Unit\Countries\US\Oregon;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Oregon\OregonUnemployment\OregonUnemployment;
use Carbon\Carbon;
use TestCase;

class OregonUnemploymentTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
		Carbon::setTestNow(Carbon::parse('2019-01-01'));
	}
}
