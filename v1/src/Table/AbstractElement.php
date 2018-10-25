<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:16
 */

namespace Flexe\Table;


class AbstractElement extends AbstractCommon
{

    protected $variables = [];

    protected $decorators = [];

    protected $attributes = [];

    protected $class = [];

    protected $varClass = [];

    protected $varAttr= [];


    /**
     * Add new class to element
     *
     * @param string $class
     * @return $this
     */
    public function addClass($class)
    {
        if (!in_array($class, $this->class)) {

            $this->class[] = $class;

        }

        return $this;
    }

    /**
     * Remove class from element
     *
     * @param string $class
     * @return $this
     */
    public function removeClass($class)
    {
        if (($key = array_search($class, $this->class)) !== false) {

            unset($this->class[$key]);

        }

        return $this;
    }

    /**
     * Add new var class to element
     *
     * @param string $class
     * @return $this
     */
    public function addVarClass($class)
    {
        if (!in_array($class, $this->varClass)) {

            $this->varClass[] = $class;

        }

        return $this;
    }

    /**
     * Add new var class to element
     *
     * @param $name
     * @param $value
     * @return $this
     */

    public function addVarAttr($name, $value)
    {

        if (!in_array($name, $this->varAttr)) {

            $this->varAttr[$name] = $value;

        }

        return $this;

    }

    /**
     * Add new attribute to table, header, column or rowset
     *
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function addAttr($name, $value)
    {
        if (!in_array($name, $this->attributes)) {

            $this->attributes[$name] = $value;

        }

        return $this;

    }
    public function getAttrs(){

        return $this->getAttributes();

    }

    /**
     * Get string class from array
     * @return string
     */
    public function getClassName()
    {
        $className = '';

        if (count($this->class)) {
            $className = implode(' ', array_values($this->class));
        }

        if (count($this->varClass)) {
            $className .= ' ';
            $className .= implode(' ', array_values($this->varClass));
        }
        return $className;
    }

    /**
     * Get attributes as a string
     *
     * @return null|string
     */
    public function getAttributes()
    {
        $ret = array();

        if (count($this->attributes)) {
            foreach ($this->attributes as $name => $value) {
                $ret[] = sprintf($name . '="%s"', $value);
            }
        }

        if (count($this->varAttr)) {
            foreach ($this->varAttr as $name => $value) {
                $ret[] = sprintf($name . '="%s"', $value);
            }
        }

        if (strlen($className = $this->getClassName())) {
            $ret[] = sprintf('class="%s"', $className);
        }

        return ' ' . implode(' ', $ret);
    }

    /**
     * @param array $attributes
     * @return AbstractElement
     */
    public function setAttributes(array $attributes): AbstractElement
    {
        if($attributes):

            foreach ($attributes as $key => $attribute):

                $this->setAttribute($key, $attribute);

            endforeach;

        endif;

        return $this;
    }

    /**
     * @param array $attributes
     * @return AbstractElement
     */
    public function setAttribute($key, $attribute): AbstractElement
    {
        $this->attributes[$key] = $attribute;

        return $this;
    }

    public function clearVar()
    {

        $this->varClass = [];

        $this->class = [];

        $this->varAttr = [];

        $this->attributes = [];

    }

    public function getDecorators(){

        return $this->decorators;

    }


    public function attachDecorators($decorators){

        $this->decorators[] = $decorators;

        return $this;
    }

    public function setVariables(array $variables){

        if($variables):

            foreach ($variables as $key => $variable):

                $this->setVariable($key, $variable);

            endforeach;

        endif;

        return $this;
    }

    public function setVariable($key, $variable){

         $this->variables[$key] = $variable;

         return $this;
    }

}