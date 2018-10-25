<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;

use Flexe\Form\Elements\Decimal;
use Flexe\Form\Elements\Text;

trait DecimalTrait
{

    protected $templateDecimal;

    protected $elementDecimal;

    protected $labelDecimal;

    protected $valueDecimal;

    protected $optionsDecimal = [];

    protected $attributesDecimal = [];

    protected $validateDecimal = [];

    public function addDecimal($name){

        if(!empty($this->valueDecimal)):

            $this->getAttributesDecimal([
                'value'=>$this->valueDecimal
            ]);

        endif;

        $this->elementDecimal = [

            'name'=>$name,

            'type'=>Decimal::class,

            'options'=>$this->getOptionsDecimal([

                'label'=>$this->getLabelDecimal($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesDecimal([


                'class'=>sprintf("%s real", Text::getOptionDefault('class', 'form-control')),

                'position'=>Text::getOptionDefault('position','prepend'),

            ]),

            'validate'=>$this->getValidateDecimal(),

            'template'=>$this->templateDecimal

        ];

        $this->validateDecimal = [];

        $this->attributesDecimal = [];

        return $this->elementDecimal;


    }

    /**
     * @param $template
     * @return $this
     */
    public function setTemplateDecimal($template){

        $this->templateDecimal = $template;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getElementDecimal()
    {
        return $this->elementDecimal;
    }

    /**
     * @param mixed $elementDecimal
     * @return DecimalTrait
     */
    public function setElementDecimal($elementDecimal)
    {
        $this->elementDecimal = $elementDecimal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelDecimal($default)
    {
        return empty($this->labelDecimal)?$default:$this->labelDecimal;
    }

    /**
     * @param mixed $labelDecimal
     * @return DecimalTrait
     */
    public function setLabelDecimal($labelDecimal)
    {
        $this->labelDecimal = $labelDecimal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueDecimal()
    {
        return $this->valueDecimal;
    }

    /**
     * @param mixed $valueDecimal
     * @return DecimalTrait
     */
    public function setValueDecimal($valueDecimal)
    {
        $this->valueDecimal = $valueDecimal;
        return $this;
    }

    /**
     * @param $optionsDecimal
     * @return array
     */
    public function getOptionsDecimal($optionsDecimal): array
    {
        return array_merge($optionsDecimal, $this->optionsDecimal);
    }

    /**
     * @param array $optionsDecimal
     * @return DecimalTrait
     */
    public function setOptionsDecimal(array $optionsDecimal)
    {
        $this->optionsDecimal = $optionsDecimal;
        return $this;
    }

    /**
     * @param $attributesDecimal
     * @return array
     */
    public function getAttributesDecimal($attributesDecimal): array
    {
        return array_merge($attributesDecimal, $this->attributesDecimal);
    }

    /**
     * @param array $attributesDecimal
     * @return DecimalTrait
     */
    public function setAttributesDecimal(array $attributesDecimal)
    {
        $this->attributesDecimal = $attributesDecimal;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateDecimal(): array
    {
        return $this->validateDecimal;
    }

    /**
     * @param array $validateDecimal
     * @return DecimalTrait
     */
    public function setValidateDecimal(array $validateDecimal)
    {
        $this->validateDecimal = $validateDecimal;
        return $this;
    }

}