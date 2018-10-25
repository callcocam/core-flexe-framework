<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 18:44
 */

namespace Flexe\Table\Decorator;


class DecoratorFactory
{


    private static $namespace;

    public static function factoryCell($name, $options){

        self::$namespace = "\\Flexe\\Table\\Decorator\\Cell\\Plugin";

        $decorator = self::plugin($name);

        return $decorator->newInstanceArgs([$options]);
    }

    private static function plugin($name){

        $instace = new \ReflectionClass(sprintf("%s\\%sDecorator",self::$namespace, title_case($name)));

        return $instace;
    }

}