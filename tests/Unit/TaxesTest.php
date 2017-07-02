<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\FederalIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class TaxesTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = $this->user_model->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);
    }

    public function testTaxes()
    {
        $taxes = $this->app->make(Taxes::class);
        $this->assertSame(1, $this->user_model->count());
    }
}
