<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20190101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer as ParentSocialSecurityEmployer;

class SocialSecurityEmployerTest extends \TestCase
{
    public function testCaseStudy2019A()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(640);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(39.68, $results->getTax(ParentSocialSecurityEmployer::class));
    }

    public function testCaseStudy2019B()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(774.28);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(48.01, $results->getTax(ParentSocialSecurityEmployer::class));
    }

    public function testCaseStudy2019C()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(640);
            $taxes->setYtdEarnings(133000);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(null, $results->getTax(ParentSocialSecurityEmployer::class));
    }

    public function testCaseStudy2019D()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(774.28);
            $taxes->setYtdEarnings(133000);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(null, $results->getTax(ParentSocialSecurityEmployer::class));
    }
}
