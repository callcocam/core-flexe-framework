<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Select;

trait SelectTrait
{
    protected $templateSelect;

    protected $elementSelect;

    protected $labelSelect;

    protected $optionsSelect = [];

    protected $valueOptionSelect = [];

    protected $attributesSelect = [];

    protected $validateSelect = [];

    public function addSelect($name){


        $this->elementSelect = [

            'name'=>$name,

            'type'=>Select::class,

            'options'=>$this->getOptionsSelect([

                'label'=>$this->getLabelSelect($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ],
                //'option_empty'=>'--Selecione--',
                'value_option'=>$this->getValueOptionSelect()

            ]),
            'attributes'=> $this->getAttributesSelect([

                'class'=>Select::getOptionDefault('class', 'form-control'),

                'position'=>Select::getOptionDefault('position','prepend'),

            ]),

            'validate'=>$this->getValidateSelect(),

            'template'=>$this->templateSelect

        ];

        $this->validateSelect = [];

        $this->attributesSelect = [];

        return $this->elementSelect;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateSelect($template){

        $this->templateSelect = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementSelect()
    {
        return $this->elementSelect;
    }

    /**
     * @param mixed $elementSelect
     * @return SelectTrait
     */
    public function setElementSelect($elementSelect)
    {
        $this->elementSelect = $elementSelect;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelSelect($default)
    {
        return empty($this->labelSelect)?$default:$this->labelSelect;
    }

    /**
     * @param mixed $labelSelect
     * @return SelectTrait
     */
    public function setLabelSelect($labelSelect)
    {
        $this->labelSelect = $labelSelect;
        return $this;
    }

    /**
     * @return array
     */
    public function getValueOptionSelect(): array
    {
        return $this->valueOptionSelect;
    }

    /**
     * @param array $valueOptionSelect
     * @return SelectTrait
     */
    public function setValueOptionSelect(array $valueOptionSelect)
    {
        $this->valueOptionSelect = $valueOptionSelect;
        return $this;
    }

    /**
     * @param $optionsSelect
     * @return array
     */
    public function getOptionsSelect($optionsSelect): array
    {
        return array_merge($optionsSelect, $this->optionsSelect);
    }

    /**
     * @param array $optionsSelect
     * @return SelectTrait
     */
    public function setOptionsSelect(array $optionsSelect)
    {
        $this->optionsSelect = $optionsSelect;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesSelect($attributesSelect): array
    {
        return array_merge($attributesSelect, $this->attributesSelect);
    }

    /**
     * @param array $attributesSelect
     * @return SelectTrait
     */
    public function setAttributesSelect(array $attributesSelect)
    {
        $this->attributesSelect = $attributesSelect;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateSelect(): array
    {
        return $this->validateSelect;
    }

    /**
     * @param array $validateSelect
     * @return SelectTrait
     */
    public function setValidateSelect(array $validateSelect)
    {
        $this->validateSelect = $validateSelect;
        return $this;
    }

}