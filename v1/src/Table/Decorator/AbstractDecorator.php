<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 20:13
 */

namespace Flexe\Table\Decorator;


use Flexe\Table\AbstractCommon;
use Flexe\Table\Decorator\Condition\ConditionFactory;

abstract class AbstractDecorator extends AbstractCommon implements DataAccessInterface
{


    protected $conditions = [];


    public function addCondition($name, $options){


        if($this instanceof DataAccessInterface):

            $condition = ConditionFactory::factoryCondition($name, $options);

            $condition->setDecorator($this);

            $this->attachCondition($condition);

            return $this;

        endif;
    }

    protected function attachCondition($condition){

        $this->conditions[] = $condition;

    }

    public function validConditions(){

        if(!count($this->conditions)):

            return true;

        endif;

        foreach ($this->conditions as $condition):

            if(!$condition->isValid()):

                return false;

            endif;

        endforeach;

        return true;

    }

}

















