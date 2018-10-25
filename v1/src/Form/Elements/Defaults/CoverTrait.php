<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Cover;

trait CoverTrait
{
    protected $templateCover;

    protected $elementCover;

    protected $labelCover;

    protected $valueCover;

    protected $optionsCover = [];

    protected $attributesCover = [];

    protected $validateCover = [];

    public function addCover($name = 'image'){

        $this->elementCover = [

            'name'=>$name,

            'type'=>Cover::class,

            'options'=>$this->getOptionsCover([

                'label'=>$this->getLabelCover($name),

                'label_attributes'=>[

                    'class'=>'btn btn-warning btn-block'

                ]

            ]),
            'attributes'=> $this->getAttributesCover([

                "class"=>"form-control-file",

                "id"=>"image-upload",

                "style"=>"display:none",

                'data-preview'=>'#upload-preview',

                'position'=>'append',

            ]),

            'validate'=>$this->getValidateCover()

        ];

        $this->validateCover = [];

        $this->attributesCover = [];

        return $this->elementCover;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateCover($template){

        $this->templateCover = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementCover()
    {
        return $this->elementCover;
    }

    /**
     * @param mixed $elementCover
     * @return CoverTrait
     */
    public function setElementCover($elementCover)
    {
        $this->elementCover = $elementCover;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelCover($default)
    {
        return empty($this->labelCover)?$default:$this->labelCover;
    }

    /**
     * @param mixed $labelCover
     * @return CoverTrait
     */
    public function setLabelCover($labelCover)
    {
        $this->labelCover = $labelCover;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueCover()
    {
        return $this->valueCover;
    }

    /**
     * @param mixed $valueCover
     * @return CoverTrait
     */
    public function setValueCover($valueCover)
    {
        $this->valueCover = $valueCover;
        return $this;
    }

    /**
     * @param $optionsCover
     * @return array
     */
    public function getOptionsCover($optionsCover): array
    {
        return array_merge($optionsCover, $this->optionsCover);
    }

    /**
     * @param array $optionsCover
     * @return CoverTrait
     */
    public function setOptionsCover(array $optionsCover)
    {
        $this->optionsCover = $optionsCover;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesCover($attributesCover): array
    {
        return array_merge($attributesCover, $this->attributesCover);
    }

    /**
     * @param array $attributesCover
     * @return CoverTrait
     */
    public function setAttributesCover(array $attributesCover)
    {
        $this->attributesCover = $attributesCover;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateCover(): array
    {
        return $this->validateCover;
    }

    /**
     * @param array $validateCover
     * @return CoverTrait
     */
    public function setValidateCover(array $validateCover)
    {
        $this->validateCover = $validateCover;
        return $this;
    }

}