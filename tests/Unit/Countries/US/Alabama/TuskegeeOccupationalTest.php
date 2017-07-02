<?php

namespace Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational;

class TuskegeeOccupationalTest extends \TestCase
{
    public function testTuskegeeOccupational()
    {
        $result = $this->app->makeWith(TuskegeeOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(46.00, $result);
    }
}
