<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 30/08/2018
 * Time: 16:36
 */

namespace Flexe\Form\Elements\Traits;


use Flexe\Db\Commons\Queries\Select;
use Flexe\Db\Init;

trait TargetClassTrait
{


    /**
     * @var Init
     */
    protected $object_manager;
    /**
     * @var Select
     */
    protected $target_class;

    protected $property;

    protected $properties;

    protected $params;

    protected $criteria;

    protected $orderBy;

    protected $find_method;

    protected $null;

    protected $not_null;

    /**
     * @return Init
     */
    public function getObjectManager(): Init
    {
               return $this->object_manager;
    }

    /**
     * @param Init $object_manager
     * @return TargetClassTrait
     */
    public function setObjectManager(Init $object_manager)
    {
        $this->object_manager = $object_manager;
        return $this;
    }

    /**
     * @return Select
     */
    public function getTargetClass(): Select
    {
        return $this->target_class;
    }

    /**
     * @param Select $target_class
     * @return TargetClassTrait
     */
    public function setTargetClass(Select $target_class)
    {
        $this->target_class = $target_class;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $property
     * @return TargetClassTrait
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     * @return TargetClassTrait
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     * @return TargetClassTrait
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param mixed $criteria
     * @return TargetClassTrait
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     * @return TargetClassTrait
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFindMethod()
    {
        return $this->find_method;
    }

    /**
     * @param mixed $find_method
     * @return TargetClassTrait
     */
    public function setFindMethod($find_method)
    {
        $this->find_method = $find_method;

        $this->setParams($this->find_method['params']);

        if(isset($this->find_method['criteria'])):

            $this->setCriteria($this->find_method['criteria']);

        endif;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNull()
    {
        return $this->null;
    }

    /**
     * @param mixed $null
     * @return TargetClassTrait
     */
    public function setNull($null)
    {
        $this->null = $null;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotNull()
    {
        return $this->not_null;
    }

    /**
     * @param mixed $not_null
     * @return TargetClassTrait
     */
    public function setNotNull($not_null)
    {
        $this->not_null = $not_null;
        return $this;
    }




}