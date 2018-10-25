<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Email;

trait EmailTrait
{
    protected $templateEmail;

    protected $elementEmail;

    protected $labelEmail;

    protected $valueEmail;

    protected $optionsEmail = [];

    protected $attributesEmail = [];

    protected $validateEmail = [];

    public function addEmail($name){

        if(!empty($this->valueEmail)):

            $this->getAttributesEmail([
                'value'=>$this->valueEmail
            ]);

        endif;

        $this->elementEmail = [

            'name'=>$name,

            'type'=>Email::class,

            'options'=>$this->getOptionsEmail([

                'label'=>$this->getLabelEmail('Digite Seu E-Mail'),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesEmail([

                'class'=>Email::getOptionDefault('class', 'form-control'),

                'position'=>Email::getOptionDefault('position','prepend'),

            ]),

            'validate'=>$this->getValidateEmail(),

            'template'=>$this->templateEmail

        ];

        $this->validateEmail = [];

        $this->attributesEmail = [];

        return $this->elementEmail;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateEmail($template){

        $this->templateEmail = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementEmail()
    {
        return $this->elementEmail;
    }

    /**
     * @param mixed $elementEmail
     * @return EmailTrait
     */
    public function setElementEmail($elementEmail)
    {
        $this->elementEmail = $elementEmail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelEmail($default)
    {
        return empty($this->labelEmail)?$default:$this->labelEmail;
    }

    /**
     * @param mixed $labelEmail
     * @return EmailTrait
     */
    public function setLabelEmail($labelEmail)
    {
        $this->labelEmail = $labelEmail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueEmail()
    {
        return $this->valueEmail;
    }

    /**
     * @param mixed $valueEmail
     * @return EmailTrait
     */
    public function setValueEmail($valueEmail)
    {
        $this->valueEmail = $valueEmail;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptionsEmail($optionsEmail): array
    {
        return array_merge($optionsEmail, $this->optionsEmail);
    }

    /**
     * @param array $optionsEmail
     * @return EmailTrait
     */
    public function setOptionsEmail(array $optionsEmail)
    {
        $this->optionsEmail = $optionsEmail;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesEmail($attributesEmail): array
    {
        return array_merge($attributesEmail, $this->attributesEmail);
    }

    /**
     * @param array $attributesEmail
     * @return EmailTrait
     */
    public function setAttributesEmail(array $attributesEmail)
    {
        $this->attributesEmail = $attributesEmail;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateEmail(): array
    {
        return $this->validateEmail;
    }

    /**
     * @param array $validateEmail
     * @return EmailTrait
     */
    public function setValidateEmail(array $validateEmail)
    {
        $this->validateEmail = $validateEmail;
        return $this;
    }

}