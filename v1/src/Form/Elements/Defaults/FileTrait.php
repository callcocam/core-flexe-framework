<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 13/09/2018
 * Time: 10:43
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\File;

trait FileTrait
{
    protected $templateFile;

    protected $elementFile;
    protected $nameFile;
    protected $labelFile;
    protected $optionsFile = [];
    protected $attributesFile = [];
    protected $validateFile = [];
    public function addFile($name = 'file'){

        $this->elementFile = [
            'type' => File::class,
            'name' => $this->getNameFile($name),
            'options' => $this->getOptionsFile([
                'label'=>$this->getLabelFile('Selecione uma file '),
            ]),
            'attributes'=>$this->getAttributesFile([
                "class"=>"input-material",
                "id"=>"file-upload"
            ]),
            'validate'=>$this->getValdateFile([]),

            'template'=>$this->templateFile
        ];
        return $this->elementFile;
    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateFile($template){

        $this->templateFile = $template;

        return $this;
    }
    /**
     * @param $default
     * @return mixed
     */
    public function getNameFile($default)
    {
        return empty($this->nameFile)?$default:$this->nameFile;
    }

    /**
     * @param mixed $nameFile
     * @return FileTrait
     */
    public function setNameFile($nameFile)
    {
        $this->nameFile = $nameFile;
        return $this;
    }

    /**
     * @param $default
     * @return mixed
     */
    public function getLabelFile($default)
    {
        return empty($this->labelFile)?$default:$this->labelFile;
    }

    /**
     * @param mixed $labelFile
     * @return FileTrait
     */
    public function setLabelFile($labelFile)
    {
        $this->labelFile = $labelFile;
        return $this;
    }

    /**
     * @param $attributesFile
     * @return mixed
     */
    public function getAttributesFile($attributesFile)
    {
        return array_merge($attributesFile,$this->attributesFile);
    }

    /**
     * @param mixed $attributesFile
     * @return FileTrait
     */
    public function setAttributesFile($attributesFile)
    {
        $this->attributesFile = $attributesFile;
        return $this;
    }

    /**
     * @param $optionsFile
     * @return mixed
     */
    public function getOptionsFile($optionsFile)
    {
        return array_merge($optionsFile,$this->optionsFile);
    }

    /**
     * @param mixed $attributesFile
     * @return FileTrait
     */
    public function setOptionsFile($attributesFile)
    {
        $this->optionsFile = $attributesFile;
        return $this;
    }

    /**
     * @param $validateFile
     * @return mixed
     */
    public function getValdateFile($validateFile)
    {
        return array_merge($validateFile,$this->validateFile);
    }

    /**
     * @param mixed $validateFile
     * @return FileTrait
     */
    public function setValidateFile($validateFile)
    {
        $this->validateFile = $validateFile;
        return $this;
    }
}