<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20180101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer as ParentSocialSecurityEmployer;

class SocialSecurityEmployerTest extends \TestCase
{
    public function testCaseStudy2018A()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(640);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(39.68, $results->getTax(ParentSocialSecurityEmployer::class));
    }

    public function testCaseStudy2018B()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(774.28);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(48.01, $results->getTax(ParentSocialSecurityEmployer::class));
    }

    public function testCaseStudy2018C()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(640);
            $taxes->setYtdEarnings(128500);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(ParentSocialSecurityEmployer::class));
    }

    public function testCaseStudy2018D()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(774.28);
            $taxes->setYtdEarnings(128500);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(ParentSocialSecurityEmployer::class));
    }
}
