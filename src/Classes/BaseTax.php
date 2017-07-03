<?php

namespace Appleton\Taxes\Classes;

class BaseTax
{
    public static function getType()
    {
        return get_called_class()::TYPE;
    }

    public static function getWithheld()
    {
        return get_called_class()::WITHHELD;
    }

    public function build($parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->$key = $value;
        }
        if (defined('static::TAX_INFORMATION')) {
            $this->tax_information = (static::TAX_INFORMATION)::forUser($this->user)->first();
            if (is_null($this->tax_information)) {
                throw new \Exception('The tax information for that user could not be loaded.');
            }
        }
        return $this;
    }

    public function compute()
    {
        return round($this->earnings * get_called_class()::TAX_RATE, 2);
    }
}
