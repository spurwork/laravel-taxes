<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

class SocialSecurityTest extends \TestCase
{
    public function testSocialSecurity()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(38.9072, -77.0369);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(142.60, $results->getTax(SocialSecurity::class));
    }

    public function testSocialSecurityEmployer()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(38.9072, -77.0369);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(142.60, $results->getTax(SocialSecurityEmployer::class));
    }

    public function testSocialSecurityMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(38.9072, -77.0369);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setYtdEarnings(127200);
        });

        $this->assertSame(0.0, $results->getTax(SocialSecurity::class));
    }

    public function testCaseStudy1()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(38.9072, -77.0369);
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(4.13, $results->getTax(SocialSecurity::class));
    }
}
