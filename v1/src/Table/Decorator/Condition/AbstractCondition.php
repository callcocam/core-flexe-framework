<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 20:31
 */

namespace Flexe\Table\Decorator\Condition;


abstract class AbstractCondition implements ConditionInterface
{

    protected $decorator = [];

    protected $options = [];


    abstract public function __construct(array $options = []);

    /**
     * @return array
     */
    public function getDecorator(): array
    {
        return $this->decorator;
    }

    /**
     * @param array $decorator
     * @return AbstractCondition
     */
    public function setDecorator($decorator): AbstractCondition
    {
        $this->decorator = $decorator;
        return $this;
    }

    public function getActualRow(){

        return $this->decorator->getActualRow();

    }
}