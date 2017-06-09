<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Countries\US;

class SocialSecurityTest extends \TestCase
{
    public function testSocialSecurity()
    {
        $taxes = $this->app->make(SocialSecurity::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(142.60, $result);
    }

    public function testSocialSecurityEmployer()
    {
        $taxes = $this->app->make(SocialSecurityEmployer::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(142.60, $result);
    }

    public function testSocialSecurityMetWageBase()
    {
        $taxes = $this->app->make(SocialSecurity::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(SocialSecurity::WAGE_BASE)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testCaseStudy1()
    {
        $taxes = $this->app->make(SocialSecurity::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(4.13, $result);
    }
}
