<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class WashingtonUnemployment extends BaseStateUnemployment
{
	const TYPE = 'state';
	const WITHHELD = false;
}