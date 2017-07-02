<?php

namespace Appleton\Taxes\Classes;

use Carbon\Carbon;

class BaseTaxStrategy
{
    protected $strategy;

    public function __construct($date = null)
    {
        $class_name = self::getClassName(isset($arguments[0]) ? $arguments[0] : Carbon::now());

        $attributes = [];
        $constructor = new \ReflectionMethod(get_called_class(), '__construct');
        foreach ($constructor->getParameters() as $parameter) {
            $attributes[$parameter->getName()] = func_get_arg($parameter->getPosition());
        }

        $this->strategy = app()->makeWith($class_name, $attributes);
    }

    public static function __callStatic($name, $arguments)
    {
        $class_name = self::getClassName(isset($arguments[0]) ? $arguments[0] : Carbon::now());

        return $class_name::$name();
    }

    public static function getClassName($date = null) {
        $date = is_null($date) ? Carbon::now() : $date;
        $base_name = class_basename(get_called_class());
        $namespace = substr(get_called_class(), 0, -strlen($base_name) - 1);

        foreach (get_called_class()::STRATEGIES as $strategy_name) {
            if ($date->gte(Carbon::createFromFormat('Ymd', $strategy_name))) {
                $strategy = $strategy_name;
            }
        }

        return $namespace.'\\V'.$strategy.'\\'.$base_name;
    }

    public function compute()
    {
        return $this->strategy->compute();
    }
}
