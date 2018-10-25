<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 20:29
 */

namespace Flexe\Table\Decorator\Condition;


class ConditionFactory
{


    private static $namespace;

    public static function factoryCondition($name, $options){

        self::$namespace = "\\Flexe\\Table\\Decorator\\Condition\\Plugin";

        $decorator = self::plugin($name);

        return $decorator->newInstanceArgs([$options]);
    }

    private static function plugin($name){

        $instace = new \ReflectionClass(sprintf("%s\\%s",self::$namespace, title_case($name)));

        return $instace;
    }

}