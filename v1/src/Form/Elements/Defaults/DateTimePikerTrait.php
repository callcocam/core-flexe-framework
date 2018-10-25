<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * DateTimePiker: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\DateTime;

trait DateTimePikerTrait
{
    protected $templateDateTimePiker = 'datetimepicker';

    protected $elementDateTimePiker;

    protected $labelDateTimePiker;

    protected $valueDateTimePiker;

    protected $optionsDateTimePiker = [];

    protected $attributesDateTimePiker = [];

    protected $validateTimeDateTimePiker = [];

    public function addDateTimePiker($name='updated_at'){

       $this->elementDateTimePiker = [

            'name'=>$name,

            'type'=>DateTime::class,

            'options'=>$this->getOptionsDateTimePiker([

                'label'=>$this->getLabelDateTimePiker($name),

                'label_attributes'=>[

                    'class'=>DateTime::getOptionDefault('label_attributes.class','label-material')

                ]

            ]),
            'attributes'=> $this->getAttributesDateTimePiker([

                'class'=>sprintf("%s datetimepicker",DateTime::getOptionDefault('class','form-control')),

                'position'=>DateTime::getOptionDefault('position','prepend'),

                'value'=>date("d/m/Y H:i:s"),

                'autocomplete'=>'off'

            ]),
            
            'validateTime'=>$this->getValidateTimeDateTimePiker(),

           'template'=>$this->templateDateTimePiker

        ];

        $this->validateTimeDateTimePiker = [];

        $this->attributesDateTimePiker = [];

        return $this->elementDateTimePiker;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateDateTimePiker($template){

        $this->templateDateTimePiker = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementDateTimePiker()
    {
        return $this->elementDateTimePiker;
    }

    /**
     * @param mixed $elementDateTimePiker
     * @return DateTimePikerTrait
     */
    public function setElementDateTimePiker($elementDateTimePiker)
    {
        $this->elementDateTimePiker = $elementDateTimePiker;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelDateTimePiker($default)
    {
        return empty($this->labelDateTimePiker)?$default:$this->labelDateTimePiker;
    }

    /**
     * @param mixed $labelDateTimePiker
     * @return DateTimePikerTrait
     */
    public function setLabelDateTimePiker($labelDateTimePiker)
    {
        $this->labelDateTimePiker = $labelDateTimePiker;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueDateTimePiker()
    {
        return $this->valueDateTimePiker;
    }

    /**
     * @param mixed $valueDateTimePiker
     * @return DateTimePikerTrait
     */
    public function setValueDateTimePiker($valueDateTimePiker)
    {
        $this->valueDateTimePiker = $valueDateTimePiker;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptionsDateTimePiker($optionsDateTimePiker): array
    {
        return array_merge($optionsDateTimePiker, $this->optionsDateTimePiker);
    }

    /**
     * @param array $optionsDateTimePiker
     * @return DateTimePikerTrait
     */
    public function setOptionsDateTimePiker(array $optionsDateTimePiker)
    {
        $this->optionsDateTimePiker = $optionsDateTimePiker;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesDateTimePiker($attributesDateTimePiker): array
    {
        return array_merge($attributesDateTimePiker, $this->attributesDateTimePiker);
    }

    /**
     * @param array $attributesDateTimePiker
     * @return DateTimePikerTrait
     */
    public function setAttributesDateTimePiker(array $attributesDateTimePiker)
    {
        $this->attributesDateTimePiker = $attributesDateTimePiker;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateTimeDateTimePiker(): array
    {
        return $this->validateTimeDateTimePiker;
    }

    /**
     * @param array $validateTimeDateTimePiker
     * @return DateTimePikerTrait
     */
    public function setValidateTimeDateTimePiker(array $validateTimeDateTimePiker)
    {
        $this->validateTimeDateTimePiker = $validateTimeDateTimePiker;
        return $this;
    }

}