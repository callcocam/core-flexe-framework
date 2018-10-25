<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:18
 */

namespace Flexe\Table\Sources;


use Flexe\Table\Params\AbstractParam;

abstract class AbstractSource
{

    use DateRange;

    protected $source;

    protected $select;

    protected $table;

    /**
     * @var AbstractParam
     */
    protected $params;

    /**
     * AbstractSource constructor.
     * @param $source
     * @param $table
     */
   abstract public function __construct($source, $table);

   abstract protected function order();

   abstract protected function quickSearch();

   abstract public function getData();

   protected function initQuery(){


       $this->quickSearch();

       $this->order();

   }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getSelect()
    {
        return $this->select;
    }

     /**
     * @return AbstractParam
     */
    public function getParams()
    {
        return $this->table->getParams();
    }

    /**
     * @param AbstractParam $params
     * @return AbstractSource
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }




}