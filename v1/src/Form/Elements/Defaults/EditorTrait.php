<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 11:53
 */

namespace Flexe\Form\Elements\Defaults;


use Flexe\Form\Elements\Editor;

trait EditorTrait
{
    protected $templateEditor;

    protected $elementEditor;

    protected $labelEditor;

    protected $valueEditor;

    protected $optionsEditor = [];

    protected $attributesEditor = [];

    protected $validateEditor = [];

    public function addEditor($name){

        $this->elementEditor = [

            'name'=>$name,

            'type'=>Editor::class,

            'options'=>$this->getOptionsEditor([

                'label'=>$this->getLabelEditor($name),

                'label_attributes'=>[

                    'class'=>'label-material'

                ]

            ]),
            'attributes'=> $this->getAttributesEditor([


                'class'=>Editor::getOptionDefault('class', 'form-control editor'),

                'position'=>Editor::getOptionDefault('position','prepend'),

                'rows'=>'8',

            ]),

            'validate'=>$this->getValidateEditor(),

            'template'=>$this->templateEditor

        ];

        $this->validateEditor = [];

        $this->attributesEditor = [];

        return $this->elementEditor;


    }
    /**
     * @param $template
     * @return $this
     */
    public function setTemplateEditor($template){

        $this->templateEditor = $template;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getElementEditor()
    {
        return $this->elementEditor;
    }

    /**
     * @param mixed $elementEditor
     * @return EditorTrait
     */
    public function setElementEditor($elementEditor)
    {
        $this->elementEditor = $elementEditor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelEditor($default)
    {
        return empty($this->labelEditor)?$default:$this->labelEditor;
    }

    /**
     * @param mixed $labelEditor
     * @return EditorTrait
     */
    public function setLabelEditor($labelEditor)
    {
        $this->labelEditor = $labelEditor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueEditor()
    {
        return $this->valueEditor;
    }

    /**
     * @param mixed $valueEditor
     * @return EditorTrait
     */
    public function setValueEditor($valueEditor)
    {
        $this->valueEditor = $valueEditor;
        return $this;
    }

    /**
     * @param $optionsEditor
     * @return array
     */
    public function getOptionsEditor($optionsEditor): array
    {
        return array_merge($optionsEditor, $this->optionsEditor);
    }

    /**
     * @param array $optionsEditor
     * @return EditorTrait
     */
    public function setOptionsEditor(array $optionsEditor)
    {
        $this->optionsEditor = $optionsEditor;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesEditor($attributesEditor): array
    {
        return array_merge($attributesEditor, $this->attributesEditor);
    }

    /**
     * @param array $attributesEditor
     * @return EditorTrait
     */
    public function setAttributesEditor(array $attributesEditor)
    {
        $this->attributesEditor = $attributesEditor;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidateEditor(): array
    {
        return $this->validateEditor;
    }

    /**
     * @param array $validateEditor
     * @return EditorTrait
     */
    public function setValidateEditor(array $validateEditor)
    {
        $this->validateEditor = $validateEditor;
        return $this;
    }

}