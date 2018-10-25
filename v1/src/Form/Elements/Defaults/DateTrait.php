<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Date;
use Flexe\Form\Elements\DateTime;

trait DateTrait
{
    protected $templateDate;

    protected $elementDate;

    protected $labelDate;

    protected $valueDate;

    protected $optionsDate = [];

    protected $attributesDate = [];

    protected $validateDate = [];

    public function addDate($name='created_at'){

       $this->elementDate = [

            'name'=>$name,

            'type'=>Date::class,

            'options'=>$this->getOptionsDate([

                'label'=>$this->getLabelDate($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesDate([

                'class'=>Date::getOptionDefault('class', 'form-control'),

                'position'=>DateTime::getOptionDefault('position','prepend'),

                'value'=>date("d/m/Y"),

            ]),
            
            'validate'=>$this->getValidateDate(),

           'template'=>$this->templateDate

        ];

        $this->validateDate = [];

        $this->attributesDate = [];

        return $this->elementDate;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateDate($template){

        $this->templateDate = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementDate()
    {
        return $this->elementDate;
    }

    /**
     * @param mixed $elementDate
     * @return DateTrait
     */
    public function setElementDate($elementDate)
    {
        $this->elementDate = $elementDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelDate($default)
    {
        return empty($this->labelDate)?$default:$this->labelDate;
    }

    /**
     * @param mixed $labelDate
     * @return DateTrait
     */
    public function setLabelDate($labelDate)
    {
        $this->labelDate = $labelDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueDate()
    {
        return $this->valueDate;
    }

    /**
     * @param mixed $valueDate
     * @return DateTrait
     */
    public function setValueDate($valueDate)
    {
        $this->valueDate = $valueDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptionsDate($optionsDate): array
    {
        return array_merge($optionsDate, $this->optionsDate);
    }

    /**
     * @param array $optionsDate
     * @return DateTrait
     */
    public function setOptionsDate(array $optionsDate)
    {
        $this->optionsDate = $optionsDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesDate($attributesDate): array
    {
        return array_merge($attributesDate, $this->attributesDate);
    }

    /**
     * @param array $attributesDate
     * @return DateTrait
     */
    public function setAttributesDate(array $attributesDate)
    {
        $this->attributesDate = $attributesDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateDate(): array
    {
        return $this->validateDate;
    }

    /**
     * @param array $validateDate
     * @return DateTrait
     */
    public function setValidateDate(array $validateDate)
    {
        $this->validateDate = $validateDate;
        return $this;
    }

}