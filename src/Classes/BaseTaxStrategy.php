<?php

namespace Appleton\Taxes\Classes;

use Carbon\Carbon;

abstract class BaseTaxStrategy
{
    protected $strategy;

    public function __construct($date = null)
    {
        $attributes = [];
        $date = is_null($date) ? Carbon::now() : $date;
        $basename = class_basename(get_called_class());
        $namespace = substr(get_called_class(), 0, -strlen($basename) - 1);

        $constructor = new \ReflectionMethod(get_called_class(), '__construct');
        foreach ($constructor->getParameters() as $parameter) {
            $attributes[$parameter->getName()] = func_get_arg($parameter->getPosition());
        }

        foreach (get_called_class()::STRATEGIES as $strategy) {
            if ($date->gte(Carbon::createFromFormat('Ymd', $strategy))) {
                $this->strategy = $strategy;     
            }
        }

        if (is_null($this->strategy)) {
            throw new \Exception('Tax strategy could not be resolved.');
        }

        $this->strategy = app()->makeWith($namespace.'\\V'.$this->strategy.'\\'.$basename, $attributes);
    }

    public function compute()
    {
        return $this->strategy->compute();
    }
}
