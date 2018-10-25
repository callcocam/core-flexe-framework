<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:18
 */

namespace Flexe\Table\Params;


use Flexe\Table\AbstractCommon;
use Flexe\Table\Options\AbstractOptions;

abstract class AbstractParam extends AbstractCommon
{

    protected $params = [];

    /**
     * AbstractParam constructor.
     * @param $params
     */
    abstract public function __construct($params);

    abstract protected function init();
    /**
     * Get configuration of table
     *
     * @return AbstractOptions
     */
    public function getOptions()
    {
        return $this->getTable()->getOptions();
    }
    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getParam($key)
    {
        if(isset($this->params[$key])):

            return $this->params[$key];

        endif;

        return $key;
    }


    public function __get($name)
    {
       return $this->{$name};
    }

    public function __set($name, $value)
    {
       $this->{$name}  = $value;

       return $this;
    }


}