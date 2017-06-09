<?php

namespace Appleton\Taxes\Traits;

trait WithEarnings
{
    private $earnings;

    protected function earnings()
    {
        return $this->earnings;
    }

    public function withEarnings($earnings)
    {
        $this->earnings = $earnings;
        return $this;
    }
}
