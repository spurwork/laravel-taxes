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

        foreach (get_called_class()::STRATEGIES as $strategy_name) {
            if ($date->gte(Carbon::createFromFormat('Ymd', $strategy_name))) {
                $strategy = $strategy_name;
            }
        }

        if (is_null($strategy)) {
            throw new \Exception('Tax strategy could not be resolved.');
        }

        $this->strategy = app()->makeWith($namespace.'\\V'.$strategy.'\\'.$basename, $attributes);
    }

    public static function __callStatic($name, $arguments)
    {
        $date = !isset($arguments[0]) ? Carbon::now() : $arguments[0];
        $basename = class_basename(get_called_class());
        $namespace = substr(get_called_class(), 0, -strlen($basename) - 1);

        foreach (get_called_class()::STRATEGIES as $strategy_name) {
            if ($date->gte(Carbon::createFromFormat('Ymd', $strategy_name))) {
                $strategy = $strategy_name;
            }
        }

        if (is_null($strategy)) {
            throw new \Exception('Tax strategy could not be resolved.');
        }

        $class = $namespace.'\\V'.$strategy.'\\'.$basename;

        return $class::$name();
    }

    public function compute()
    {
        return $this->strategy->compute();
    }
}
