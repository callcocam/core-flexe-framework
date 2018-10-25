<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * DateTime: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\DateTime;

trait DateTimeTrait
{
    protected $templateDateTime;

    protected $elementDateTime;

    protected $labelDateTime;

    protected $valueDateTime;

    protected $optionsDateTime = [];

    protected $attributesDateTime = [];

    protected $validateTimeDateTime = [];

    public function addDateTime($name='updated_at'){

       $this->elementDateTime = [

            'name'=>$name,

            'type'=>DateTime::class,

            'options'=>$this->getOptionsDateTime([

                'label'=>$this->getLabelDateTime($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesDateTime([

                'class'=>DateTime::getOptionDefault('class','form-control'),

                'position'=>DateTime::getOptionDefault('position','prepend'),

                'value'=>date("d/m/Y H:i:s"),

            ]),
            
            'validateTime'=>$this->getValidateTimeDateTime(),

           'template'=>$this->templateDateTime

        ];

        $this->validateTimeDateTime = [];

        $this->attributesDateTime = [];

        return $this->elementDateTime;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateDateTime($template){

        $this->templateDateTime = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementDateTime()
    {
        return $this->elementDateTime;
    }

    /**
     * @param mixed $elementDateTime
     * @return DateTimeTrait
     */
    public function setElementDateTime($elementDateTime)
    {
        $this->elementDateTime = $elementDateTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelDateTime($default)
    {
        return empty($this->labelDateTime)?$default:$this->labelDateTime;
    }

    /**
     * @param mixed $labelDateTime
     * @return DateTimeTrait
     */
    public function setLabelDateTime($labelDateTime)
    {
        $this->labelDateTime = $labelDateTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueDateTime()
    {
        return $this->valueDateTime;
    }

    /**
     * @param mixed $valueDateTime
     * @return DateTimeTrait
     */
    public function setValueDateTime($valueDateTime)
    {
        $this->valueDateTime = $valueDateTime;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptionsDateTime($optionsDateTime): array
    {
        return array_merge($optionsDateTime, $this->optionsDateTime);
    }

    /**
     * @param array $optionsDateTime
     * @return DateTimeTrait
     */
    public function setOptionsDateTime(array $optionsDateTime)
    {
        $this->optionsDateTime = $optionsDateTime;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesDateTime($attributesDateTime): array
    {
        return array_merge($attributesDateTime, $this->attributesDateTime);
    }

    /**
     * @param array $attributesDateTime
     * @return DateTimeTrait
     */
    public function setAttributesDateTime(array $attributesDateTime)
    {
        $this->attributesDateTime = $attributesDateTime;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateTimeDateTime(): array
    {
        return $this->validateTimeDateTime;
    }

    /**
     * @param array $validateTimeDateTime
     * @return DateTimeTrait
     */
    public function setValidateTimeDateTime(array $validateTimeDateTime)
    {
        $this->validateTimeDateTime = $validateTimeDateTime;
        return $this;
    }

}