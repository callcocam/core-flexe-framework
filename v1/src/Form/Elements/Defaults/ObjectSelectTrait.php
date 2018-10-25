<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\ObjectSelect;

trait ObjectSelectTrait
{
    protected $templateObjectSelect;

    protected $elementObjectSelect;

    protected $optionAdd;

    protected $labelObjectSelect;

    protected $targetClassObjectSelect;

    protected $valueObjectSelect;

    protected $optionsObjectSelect = [];

    protected $attributesObjectSelect = [];

    protected $validateObjectSelect = [];

    public function addObjectSelect($name){

        $this->elementObjectSelect = [

            'type' => ObjectSelect::class,
            'name' => $name,
            'options' => [
                'option_empty'=>'--Selecione--',
                'label'=>$this->getLabelObjectSelect($name),
                'label_attributes'=>[
                    'class'=>'label-material'
                ],
                'target_class'   => $this->getTargetClassObjectSelect('users'),//nome da tabela
                'property'       => 'id',//valor que sera salvo no banco
                'properties'       => 'name', //valor do rotulo
                'orderBy'  => 'name DESC',
                'find_method'    => [
                    'criteria' => 'status = ?',
                    'params' => 1
                ]
            ],
            'attributes'=>$this->getAttributesObjectSelect([
                "id"=>$name,

                'class'=>ObjectSelect::getOptionDefault('class', 'form-control select-2'),

                'position'=>ObjectSelect::getOptionDefault('position','prepend'),
            ]),
            'validate'=>$this->getValidateObjectSelect(),

            'template'=>$this->templateObjectSelect


        ];

        if($this->optionAdd):

            $this->elementObjectSelect['options']['option_add'] = $this->optionAdd;

        endif;
        if($this->optionsObjectSelect):

            $this->elementObjectSelect['options'] = array_merge($this->elementObjectSelect['options'],$this->optionsObjectSelect);

        endif;

        $this->validateObjectSelect = [];

        $this->attributesObjectSelect = [];

        return $this->elementObjectSelect;
    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateObjectSelect($template){

        $this->templateObjectSelect = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementObjectSelect()
    {
        return $this->elementObjectSelect;
    }

    /**
     * @param mixed $elementObjectSelect
     * @return ObjectSelectTrait
     */
    public function setElementObjectSelect($elementObjectSelect)
    {
        $this->elementObjectSelect = $elementObjectSelect;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionAdd()
    {
        return $this->optionAdd;
    }

    /**
     * @param mixed $optionAdd
     * @return ObjectSelectTrait
     */
    public function setOptionAdd($optionAdd)
    {
        $this->optionAdd = $optionAdd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelObjectSelect($default)
    {
        return empty($this->labelObjectSelect)?$default:$this->labelObjectSelect;
    }

    /**
     * @param mixed $labelObjectSelect
     * @return ObjectSelectTrait
     */
    public function setLabelObjectSelect($labelObjectSelect)
    {
        $this->labelObjectSelect = $labelObjectSelect;
        return $this;
    }

    /**
     * @param $targetClassObjectSelect
     * @return mixed
     */
    public function getTargetClassObjectSelect($targetClassObjectSelect)
    {
        return empty($this->targetClassObjectSelect)?$targetClassObjectSelect:$this->targetClassObjectSelect;
    }

    /**
     * @param mixed $targetClassObjectSelect
     * @return ObjectSelectTrait
     */
    public function setTargetClassObjectSelect($targetClassObjectSelect)
    {
        $this->targetClassObjectSelect = $targetClassObjectSelect;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueObjectSelect()
    {
        return $this->valueObjectSelect;
    }

    /**
     * @param mixed $valueObjectSelect
     * @return ObjectSelectTrait
     */
    public function setValueObjectSelect($valueObjectSelect)
    {
        $this->valueObjectSelect = $valueObjectSelect;
        return $this;
    }

    /**
     * @param $optionsObjectSelect
     * @return array
     */
    public function getOptionsObjectSelect($optionsObjectSelect): array
    {
        return array_merge($optionsObjectSelect, $this->optionsObjectSelect);
    }

    /**
     * @param array $optionsObjectSelect
     * @return ObjectSelectTrait
     */
    public function setOptionsObjectSelect(array $optionsObjectSelect)
    {
        $this->optionsObjectSelect = $optionsObjectSelect;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesObjectSelect($attributesObjectSelect): array
    {
        return array_merge($attributesObjectSelect, $this->attributesObjectSelect);
    }

    /**
     * @param array $attributesObjectSelect
     * @return ObjectSelectTrait
     */
    public function setAttributesObjectSelect(array $attributesObjectSelect)
    {
        $this->attributesObjectSelect = $attributesObjectSelect;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateObjectSelect(): array
    {
        return $this->validateObjectSelect;
    }

    /**
     * @param array $validateObjectSelect
     * @return ObjectSelectTrait
     */
    public function setValidateObjectSelect(array $validateObjectSelect)
    {
        $this->validateObjectSelect = $validateObjectSelect;
        return $this;
    }

}