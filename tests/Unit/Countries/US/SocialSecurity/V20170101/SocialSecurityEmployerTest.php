<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer as ParentSocialSecurityEmployer;

class SocialSecurityEmployerTest extends \TestCase
{
    public function testSocialSecurityEmployer()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(142.60, $results->getTax(ParentSocialSecurityEmployer::class));
    }
}
