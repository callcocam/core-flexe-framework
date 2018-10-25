<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\TextArea;

trait TextAreaTrait
{
    protected $templateTextArea;

    protected $elementTextArea;

    protected $labelTextArea;

    protected $valueTextArea;

    protected $optionsTextArea = [];

    protected $attributesTextArea = [];

    protected $validateTextArea = [];

    public function addTextArea($name){

        $this->elementTextArea = [

            'name'=>$name,

            'type'=>TextArea::class,

            'options'=>$this->getOptionsTextArea([

                'label'=>$this->getLabelTextArea($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesTextArea([

                'class'=>TextArea::getOptionDefault('class'),

                'position'=>TextArea::getOptionDefault('position','prepend'),

                'rows'=>'8',

            ]),

            'validate'=>$this->getValidateTextArea(),

            'template'=>$this->templateTextArea

        ];

        $this->validateTextArea = [];

        $this->attributesTextArea = [];

        return $this->elementTextArea;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateTextArea($template){

        $this->templateTextArea = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementTextArea()
    {
        return $this->elementTextArea;
    }

    /**
     * @param mixed $elementTextArea
     * @return TextAreaTrait
     */
    public function setElementTextArea($elementTextArea)
    {
        $this->elementTextArea = $elementTextArea;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelTextArea($default)
    {
        return empty($this->labelTextArea)?$default:$this->labelTextArea;
    }

    /**
     * @param mixed $labelTextArea
     * @return TextAreaTrait
     */
    public function setLabelTextArea($labelTextArea)
    {
        $this->labelTextArea = $labelTextArea;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueTextArea()
    {
        return $this->valueTextArea;
    }

    /**
     * @param mixed $valueTextArea
     * @return TextAreaTrait
     */
    public function setValueTextArea($valueTextArea)
    {
        $this->valueTextArea = $valueTextArea;
        return $this;
    }

    /**
     * @param $optionsTextArea
     * @return array
     */
    public function getOptionsTextArea($optionsTextArea): array
    {
        return array_merge($optionsTextArea, $this->optionsTextArea);
    }

    /**
     * @param array $optionsTextArea
     * @return TextAreaTrait
     */
    public function setOptionsTextArea(array $optionsTextArea)
    {
        $this->optionsTextArea = $optionsTextArea;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesTextArea($attributesTextArea): array
    {
        return array_merge($attributesTextArea, $this->attributesTextArea);
    }

    /**
     * @param array $attributesTextArea
     * @return TextAreaTrait
     */
    public function setAttributesTextArea(array $attributesTextArea)
    {
        $this->attributesTextArea = $attributesTextArea;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateTextArea(): array
    {
        return $this->validateTextArea;
    }

    /**
     * @param array $validateTextArea
     * @return TextAreaTrait
     */
    public function setValidateTextArea(array $validateTextArea)
    {
        $this->validateTextArea = $validateTextArea;
        return $this;
    }

}