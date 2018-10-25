<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Submit;

trait SubmitTrait
{
    protected $templateSubmit;

    protected $elementSubmit;

    protected $labelSubmit;

    protected $IconSubmit;

    protected $attributesSubmit = [];

    public function addSubmit($name= 'submit'){


        $this->elementSubmit = [

            'name'=>$name,

            'type'=>Submit::class,

            'icon'=>$this->getIconSubmit('save'),

            'attributes'=>$this->getAttributesSubmit([

               'class'=>Submit::getOptionDefault('class', 'btn btn-primary'),

                'content'=>'Atualizar Dados'

            ]),

            'template'=>$this->templateSubmit

        ];

        $this->validateSubmit = [];

        $this->attributesSubmit = [];

        return $this->elementSubmit;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateSubmit($template){

        $this->templateSubmit = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementSubmit()
    {
        return $this->elementSubmit;
    }

    /**
     * @param mixed $elementSubmit
     * @return SubmitTrait
     */
    public function setElementSubmit($elementSubmit)
    {
        $this->elementSubmit = $elementSubmit;
        return $this;
    }

    /**
     * @param $default
     * @return mixed
     */
    public function getLabelSubmit($default)
    {
        return empty($this->labelSubmit)?$default:$this->labelSubmit;
    }

    /**
     * @param mixed $labelSubmit
     * @return SubmitTrait
     */
    public function setLabelSubmit($labelSubmit)
    {
        $this->labelSubmit = $labelSubmit;
        return $this;
    }


    /**
     * @param $IconSubmit
     * @return string
     */
    public function getIconSubmit($IconSubmit): string
    {
        return empty($this->IconSubmit)?$IconSubmit:$this->IconSubmit;
    }

    /**
     * @param string $IconSubmit
     * @return SubmitTrait
     */
    public function setIconSubmit(string $IconSubmit)
    {
        $this->IconSubmit = $IconSubmit;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesSubmit($attributesSubmit): array
    {
        return array_merge($attributesSubmit, $this->attributesSubmit);
    }

    /**
     * @param array $attributesSubmit
     * @return SubmitTrait
     */
    public function setAttributesSubmit(array $attributesSubmit)
    {
        $this->attributesSubmit = $attributesSubmit;
        return $this;
    }

}