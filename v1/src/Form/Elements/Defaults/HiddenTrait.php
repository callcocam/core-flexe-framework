<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Hidden;

trait HiddenTrait
{

    protected $elementHidden;

    protected $valueHidden;

    protected $attributesHidden = [];

    public function addHidden($name){

        if(!empty($this->valueHidden)):

            $this->setAttributesHidden([
                'value'=>$this->valueHidden
            ]);

        endif;

        $this->elementHidden = [

            'name'=>$name,

            'type'=>Hidden::class,

            'attributes'=> $this->getAttributesHidden([

                'id'=>$name

            ])

        ];


        $this->attributesHidden = [];

        return $this->elementHidden;


    }

    /**
     * @return mixed
     */
    public function getElementHidden()
    {
        return $this->elementHidden;
    }

     /**
     * @return mixed
     */
    public function getValueHidden()
    {
        return $this->valueHidden;
    }

    /**
     * @param mixed $valueHidden
     * @return HiddenTrait
     */
    public function setValueHidden($valueHidden)
    {
        $this->valueHidden = $valueHidden;
        return $this;
    }



    /**
     * @return array
     */
    public function getAttributesHidden($attributesHidden): array
    {
        return array_merge($attributesHidden, $this->attributesHidden);
    }

    /**
     * @param array $attributesHidden
     * @return HiddenTrait
     */
    public function setAttributesHidden(array $attributesHidden)
    {
        $this->attributesHidden = $attributesHidden;
        return $this;
    }



}