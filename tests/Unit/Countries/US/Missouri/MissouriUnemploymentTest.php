<?php

namespace Appleton\Taxes\Unit\Countries\US\Missouri;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Missouri\MissouriUnemployment\MissouriUnemployment;
use Carbon\Carbon;
use TestCase;

class MissouriUnemploymentTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
		Carbon::setTestNow(Carbon::parse('2019-01-01'));
	}
}
