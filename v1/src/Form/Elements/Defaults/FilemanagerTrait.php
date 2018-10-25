<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Filemanager;

trait FilemanagerTrait
{
    protected $templateFilemanager;

    protected $elementFilemanager;

    protected $valueFilemanager;

    protected $attributesFilemanager = [];

    protected $validateFilemanager = [];

    public function addFilemanager($name = 'cover'){

        $this->elementFilemanager = [

            'name'=>$name,

            'type'=>Filemanager::class,

            'attributes'=> $this->getAttributesFilemanager([

                "class" => Filemanager::getOptionDefault('class', 'fancybox-filemanager'),

            ]),

            'validate'=>$this->getValidateFilemanager()

        ];

        $this->validateFilemanager = [];

        $this->attributesFilemanager = [];

        return $this->elementFilemanager;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateFilemanager($template){

        $this->templateFilemanager = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementFilemanager()
    {
        return $this->elementFilemanager;
    }

    /**
     * @param mixed $elementFilemanager
     * @return FilemanagerTrait
     */
    public function setElementFilemanager($elementFilemanager)
    {
        $this->elementFilemanager = $elementFilemanager;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getValueFilemanager()
    {
        return $this->valueFilemanager;
    }

    /**
     * @param mixed $valueFilemanager
     * @return FilemanagerTrait
     */
    public function setValueFilemanager($valueFilemanager)
    {
        $this->valueFilemanager = $valueFilemanager;
        return $this;
    }


    /**
     * @return array
     */
    public function getAttributesFilemanager($attributesFilemanager): array
    {
        return array_merge($attributesFilemanager, $this->attributesFilemanager);
    }

    /**
     * @param array $attributesFilemanager
     * @return FilemanagerTrait
     */
    public function setAttributesFilemanager(array $attributesFilemanager)
    {
        $this->attributesFilemanager = $attributesFilemanager;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateFilemanager(): array
    {
        return $this->validateFilemanager;
    }

    /**
     * @param array $validateFilemanager
     * @return FilemanagerTrait
     */
    public function setValidateFilemanager(array $validateFilemanager)
    {
        $this->validateFilemanager = $validateFilemanager;
        return $this;
    }

}