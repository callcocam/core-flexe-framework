<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:19
 */

namespace Flexe\Table\Options;


abstract class AbstractOptions
{


    protected $options;

    /**
     * AbstractOptions constructor.
     * @param $options
     */
   abstract public function __construct($options);


   abstract public function int();

   public function __set($name, $value)
   {
       $this->{$name} = $value;
   }

   public function __get($name)
   {
       return $this->{$name};
   }

}