<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

class ReciprocalAgreement
{
    private $home_state;
    private $work_state;

    public function __construct(
        string $home_state,
        string $work_state)
    {
        $this->home_state = $home_state;
        $this->work_state = $work_state;
    }

    public function getHomeState(): string
    {
        return $this->home_state;
    }

    public function getWorkState(): string
    {
        return $this->work_state;
    }
}
