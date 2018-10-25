<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 09:15
 */

namespace Flexe\Helper;


class InputElement extends AbstractHelper
{

    protected $element;

    /**
     * @var array $html
     */
    protected $html = [];

    /**
     * @var $class
     */
    protected $class = 'col-md-12';

    protected $value;

    protected $field;

    protected $queryParams = [];

    protected $args = [];


    /**
     * InputElement constructor.
     * @param $element
     */
    public function __construct($element)
    {

        $this->element = $element;
    }

    /**
     * @param array $queryParams
     * @return InputElement
     */
    public function setQueryParams(array $queryParams)
    {
        $this->queryParams = $queryParams;
        return $this;
    }

    /**
     * @param array $args
     * @return InputElement
     */
    public function setArgs(array $args): InputElement
    {
        $this->args = $args;
        return $this;
    }


    /**
     * @param mixed $class
     * @return InputElement
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }


    /**
     * @param $field
     * @return $this
     */
    public function input($field){

        $this->field = $field;

        if(is_string($field)):

            if($this->value):

                $input = $this->form()->formRow($this->element->get($this->field)->setValue($this->value));

            else:

                $input =   $this->form()->formRow($this->element->get($this->field));

            endif;

        else:

            $input =   $this->form()->formRow($field);

        endif;
        $this->html[] =  $this->html('div')->setClass($this->class)->appendClass('col-xs-12')->setText(

            $this->html('div')->setClass('form-group-material')->setText(

                $input

            )
        );
        $this->value = null;
        $this->field = null;

        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function hidden($field){

        $this->field = $field;

        if($this->value):

            $this->html[] =   $this->form()->formRow($this->element->get($this->field)->setValue($this->value));

        else:

            $this->html[] =   $this->form()->formRow($this->element->get($this->field));

        endif;

        $this->value = null;
        $this->field = null;

        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function actions($field){

        $this->field = $field;

        $this->html[] =   $this->form()->formRow($this->element->get($this->field));

        $this->value = null;

        $this->field = null;

        return $this;
    }

    /**
     * @param $route
     * @param array $attributes
     * @return $this
     */
    public function add($route,$text = "Adcionar", $attributes=['class'=>'btn btn-info']){

        $queryParams = [];

        $new = 1;

        if(isset($this->queryParams['new'])):

            $new = (int)$this->queryParams['new']+1;

        endif;

        $this->queryParams['new'] = $new;

        $queryParams['query'] = $this->queryParams;

        $attributes['href'] = $this->element->getRouter($route, [] ,$queryParams);

        $this->html[] =  $this->html('a')->setAttributes($attributes)->setText(

            $this->html('i')->setClass('fa fa-plus')

        )->appendText(

                $text

            )->appendClass('navigation');

        return $this;
    }
    /**
     * @param $route
     * @param array $attributes
     * @return $this
     */
    public function back($route, $text = "Voltar", $attributes=['class'=>'btn btn-danger']){


        $attributes['href'] = $route;

        $this->html[] =  $this->html('a')->setAttributes($attributes)->setText(

            $this->html('i')->setClass('fa fa-reply')

        )->appendText(

                $text

            )->appendClass('navigation');

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value){

        $this->value =   $value;

        return $this;
    }

    public function getValue(){

        return  $this->value;

    }

    /**
     * @param array $html
     * @return InputElement
     */
    public function setHtml($html)
    {
        $this->html[] = $html;
        return $this;
    }

    public function render(HtmlElement $element = null, $row='row')
    {
        if(is_null($element)):

            $html = implode(PHP_EOL, $this->html);

        else:
            $element->setText(
            //ADD COLUNA A LINHA 02
                implode(PHP_EOL, $this->html)
            )->setClass($row);

            $html = $element->render();

        endif;
        $this->html = [];
        $this->class = 'col-md-12';
        return $html;
    }
}