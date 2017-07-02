<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

class SocialSecurityTest extends \TestCase
{
    public function testSocialSecurity()
    {
        $result = $this->app->makeWith(SocialSecurity::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(142.60, $result);
    }

    public function testSocialSecurityEmployer()
    {
        $result = $this->app->makeWith(SocialSecurityEmployer::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(142.60, $result);
    }

    public function testSocialSecurityMetWageBase()
    {
        $result = $this->app->makeWith(SocialSecurity::class, [
            'earnings' => 2300,
            'ytd_earnings' => 127200,
        ])->compute();

        $this->assertSame(0.0, $result);
    }

    public function testCaseStudy1()
    {
        $result = $this->app->makeWith(SocialSecurity::class, [
            'earnings' => 66.68,
        ])->compute();

        $this->assertSame(4.13, $result);
    }
}
