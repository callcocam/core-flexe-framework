<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Password;

trait PasswordTrait
{
    protected $templatePassword;

    protected $elementPassword;

    protected $labelPassword;

    protected $valuePassword;

    protected $optionsPassword = [];

    protected $attributesPassword = [];

    protected $validatePassword = [];

    public function addPassword($name = 'password'){

        $this->elementPassword = [

            'name'=>$name,

            'type'=>Password::class,

            'options'=>$this->getOptionsPassword([

                'label'=>$this->getLabelPassword('Digite Sua Senha'),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesPassword([

                'class'=>Password::getOptionDefault('class', 'form-control'),

                'position'=>Password::getOptionDefault('position','prepend'),

            ]),

            'validate'=>$this->getValidatePassword(),

            'template'=>$this->templatePassword

        ];

        $this->validatePassword = [];

        $this->attributesPassword = [];

        return $this->elementPassword;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplatePassword($template){

        $this->templatePassword = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementPassword()
    {
        return $this->elementPassword;
    }

    /**
     * @param mixed $elementPassword
     * @return PasswordTrait
     */
    public function setElementPassword($elementPassword)
    {
        $this->elementPassword = $elementPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelPassword($default)
    {
        return empty($this->labelPassword)?$default:$this->labelPassword;
    }

    /**
     * @param mixed $labelPassword
     * @return PasswordTrait
     */
    public function setLabelPassword($labelPassword)
    {
        $this->labelPassword = $labelPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValuePassword()
    {
        return $this->valuePassword;
    }

    /**
     * @param mixed $valuePassword
     * @return PasswordTrait
     */
    public function setValuePassword($valuePassword)
    {
        $this->valuePassword = $valuePassword;
        return $this;
    }

    /**
     * @param $optionsPassword
     * @return array
     */
    public function getOptionsPassword($optionsPassword): array
    {
        return array_merge($optionsPassword, $this->optionsPassword);
    }

    /**
     * @param array $optionsPassword
     * @return PasswordTrait
     */
    public function setOptionsPassword(array $optionsPassword)
    {
        $this->optionsPassword = $optionsPassword;
        return $this;
    }

    /**
     * @param $attributesPassword
     * @return array
     */
    public function getAttributesPassword($attributesPassword): array
    {
        return array_merge($attributesPassword, $this->attributesPassword);
    }

    /**
     * @param array $attributesPassword
     * @return PasswordTrait
     */
    public function setAttributesPassword(array $attributesPassword)
    {
        $this->attributesPassword = $attributesPassword;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidatePassword(): array
    {
        return $this->validatePassword;
    }

    /**
     * @param array $validatePassword
     * @return PasswordTrait
     */
    public function setValidatePassword(array $validatePassword)
    {
        $this->validatePassword = $validatePassword;
        return $this;
    }

}