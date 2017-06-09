<?php

namespace Appleton\Taxes\Traits;

trait WithYtdEarnings
{
    private $ytdEarnings;

    private function ytdEarnings()
    {
        return $this->ytdEarnings;
    }

    public function withYtdEarnings($ytdEarnings)
    {
        $this->ytdEarnings = $ytdEarnings;
        return $this;
    }
}
