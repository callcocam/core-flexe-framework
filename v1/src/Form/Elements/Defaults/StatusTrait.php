<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Checkbox;

trait StatusTrait
{
    protected $templateStatus;

    protected $elementStatus;

    protected $labelStatus;

    protected $valueStatus;

    protected $optionsStatus = [];

    protected $attributesStatus = [];

    protected $validateStatus = [];

    public function addStatus($name = 'status'){

        if(!empty($this->valueStatus)):

            $this->getAttributesStatus([
                'value'=>$this->valueStatus
            ]);

        endif;

        $this->elementStatus = [

            'name'=>$name,

            'type'=>Checkbox::class,

            'options'=>$this->getOptionsStatus([

                'label'=>$this->getLabelStatus($name)

            ]),
            'attributes'=> $this->getAttributesStatus([

                'class'=>'form-control-custom mt-3',

                'position'=>'checkbox',

                'data-unchek'=>'0',

                'data-check'=>'1',

            ]),

            'validate'=>$this->getValidateStatus(),

            'template'=>$this->templateStatus

        ];

        $this->validateStatus = [];

        $this->attributesStatus = [];

        return $this->elementStatus;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateStatus($template){

        $this->templateStatus = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementStatus()
    {
        return $this->elementStatus;
    }

    /**
     * @param mixed $elementStatus
     * @return StatusTrait
     */
    public function setElementStatus($elementStatus)
    {
        $this->elementStatus = $elementStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelStatus($default)
    {
        return empty($this->labelStatus)?$default:$this->labelStatus;
    }

    /**
     * @param mixed $labelStatus
     * @return StatusTrait
     */
    public function setLabelStatus($labelStatus)
    {
        $this->labelStatus = $labelStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueStatus()
    {
        return $this->valueStatus;
    }

    /**
     * @param mixed $valueStatus
     * @return StatusTrait
     */
    public function setValueStatus($valueStatus)
    {
        $this->valueStatus = $valueStatus;
        return $this;
    }

    /**
     * @param $optionsStatus
     * @return array
     */
    public function getOptionsStatus($optionsStatus): array
    {
        return array_merge($optionsStatus, $this->optionsStatus);
    }

    /**
     * @param array $optionsStatus
     * @return StatusTrait
     */
    public function setOptionsStatus(array $optionsStatus)
    {
        $this->optionsStatus = $optionsStatus;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesStatus($attributesStatus): array
    {
        return array_merge($attributesStatus, $this->attributesStatus);
    }

    /**
     * @param array $attributesStatus
     * @return StatusTrait
     */
    public function setAttributesStatus(array $attributesStatus)
    {
        $this->attributesStatus = $attributesStatus;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateStatus(): array
    {
        return $this->validateStatus;
    }

    /**
     * @param array $validateStatus
     * @return StatusTrait
     */
    public function setValidateStatus(array $validateStatus)
    {
        $this->validateStatus = $validateStatus;
        return $this;
    }

}