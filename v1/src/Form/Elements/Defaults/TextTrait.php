<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Text;

trait TextTrait
{

    protected $templateText;

    protected $elementText;

    protected $labelText;

    protected $valueText;

    protected $optionsText = [];

    protected $attributesText = [];

    protected $validateText = [];

    public function addText($name){

        if(!empty($this->valueText)):

            $this->getAttributesText([
                'value'=>$this->valueText
            ]);

        endif;

        $this->elementText = [

            'name'=>$name,

            'type'=>Text::class,

            'options'=>$this->getOptionsText([

                'label'=>$this->getLabelText($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesText([

                'class'=>Text::getOptionDefault('class', 'form-control'),

                'position'=>Text::getOptionDefault('position','prepend'),

            ]),

            'validate'=>$this->getValidateText(),

            'template'=>$this->templateText

        ];

        $this->validateText = [];

        $this->attributesText = [];

        return $this->elementText;


    }

    /**
     * @param $template
     * @return $this
     */
    public function setTemplateText($template){

        $this->templateText = $template;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getElementText()
    {
        return $this->elementText;
    }

    /**
     * @param mixed $elementText
     * @return TextTrait
     */
    public function setElementText($elementText)
    {
        $this->elementText = $elementText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelText($default)
    {
        return empty($this->labelText)?$default:$this->labelText;
    }

    /**
     * @param mixed $labelText
     * @return TextTrait
     */
    public function setLabelText($labelText)
    {
        $this->labelText = $labelText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueText()
    {
        return $this->valueText;
    }

    /**
     * @param mixed $valueText
     * @return TextTrait
     */
    public function setValueText($valueText)
    {
        $this->valueText = $valueText;
        return $this;
    }

    /**
     * @param $optionsText
     * @return array
     */
    public function getOptionsText($optionsText): array
    {
        return array_merge($optionsText, $this->optionsText);
    }

    /**
     * @param array $optionsText
     * @return TextTrait
     */
    public function setOptionsText(array $optionsText)
    {
        $this->optionsText = $optionsText;
        return $this;
    }

    /**
     * @param $attributesText
     * @return array
     */
    public function getAttributesText($attributesText): array
    {
        return array_merge($attributesText, $this->attributesText);
    }

    /**
     * @param array $attributesText
     * @return TextTrait
     */
    public function setAttributesText(array $attributesText)
    {
        $this->attributesText = $attributesText;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateText(): array
    {
        return $this->validateText;
    }

    /**
     * @param array $validateText
     * @return TextTrait
     */
    public function setValidateText(array $validateText)
    {
        $this->validateText = $validateText;
        return $this;
    }

}