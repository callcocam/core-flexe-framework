<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\FilemanagerStandalone;

trait FilemanagerStandaloneTrait
{
    protected $templateFilemanagerStandalone;

    protected $elementFilemanagerStandalone;

    protected $valueFilemanagerStandalone;

    protected $attributesFilemanagerStandalone = [];

    protected $validateFilemanagerStandalone = [];

    public function addFilemanagerStandalone($name = 'cover'){

        $this->elementFilemanagerStandalone = [

            'name'=>$name,

            'type'=>FilemanagerStandalone::class,

            'attributes'=> $this->getAttributesFilemanagerStandalone([

                "class" => FilemanagerStandalone::getOptionDefault('class', 'fancybox-filemanager'),

            ]),

            'validate'=>$this->getValidateFilemanagerStandalone()

        ];

        $this->validateFilemanagerStandalone = [];

        $this->attributesFilemanagerStandalone = [];

        return $this->elementFilemanagerStandalone;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateFilemanagerStandalone($template){

        $this->templateFilemanagerStandalone = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementFilemanagerStandalone()
    {
        return $this->elementFilemanagerStandalone;
    }

    /**
     * @param mixed $elementFilemanagerStandalone
     * @return FilemanagerStandaloneTrait
     */
    public function setElementFilemanagerStandalone($elementFilemanagerStandalone)
    {
        $this->elementFilemanagerStandalone = $elementFilemanagerStandalone;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getValueFilemanagerStandalone()
    {
        return $this->valueFilemanagerStandalone;
    }

    /**
     * @param mixed $valueFilemanagerStandalone
     * @return FilemanagerStandaloneTrait
     */
    public function setValueFilemanagerStandalone($valueFilemanagerStandalone)
    {
        $this->valueFilemanagerStandalone = $valueFilemanagerStandalone;
        return $this;
    }


    /**
     * @return array
     */
    public function getAttributesFilemanagerStandalone($attributesFilemanagerStandalone): array
    {
        return array_merge($attributesFilemanagerStandalone, $this->attributesFilemanagerStandalone);
    }

    /**
     * @param array $attributesFilemanagerStandalone
     * @return FilemanagerStandaloneTrait
     */
    public function setAttributesFilemanagerStandalone(array $attributesFilemanagerStandalone)
    {
        $this->attributesFilemanagerStandalone = $attributesFilemanagerStandalone;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateFilemanagerStandalone(): array
    {
        return $this->validateFilemanagerStandalone;
    }

    /**
     * @param array $validateFilemanagerStandalone
     * @return FilemanagerStandaloneTrait
     */
    public function setValidateFilemanagerStandalone(array $validateFilemanagerStandalone)
    {
        $this->validateFilemanagerStandalone = $validateFilemanagerStandalone;
        return $this;
    }

}