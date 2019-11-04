<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

class GeoPoint
{
    private $latitude;
    private $longitude;

    public function __construct(
        float $latitude,
        float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function toString(): string
    {
        return $this->latitude.','.$this->longitude;
    }

    public function toArray(): array
    {
        return [$this->latitude, $this->longitude];
    }
}
