<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

use Flexe\Helper\TraitHelper;

/**
 * Description of AbstractElement
 *
 * @author caltj
 */
abstract class AbstractElement {

    use TraitHelper;

    protected $id = null;
    protected $type = "text";
    protected $template = "input";
    protected $attributes = [];
    protected $options = [];
    protected $name;
    protected $value;
    protected $data;
    protected $validate = [];
    protected $path;
    protected $object_manager;
    protected $error;
    protected $validation;
    protected $exclude = ['template', 'position'];
    protected $router;

    protected static $defaultOptions = [];

    //$this->path = sprintf("%s/partials/elemments/", dirname(__DIR__, 3)');

    public function __construct($data, $validation = null)
    {
        $this->path = sprintf(config('form.elements','elements'), __APP_DIR__, __APP_PROJECT__);
    }

    abstract public function render();

    public function getAttributes() {

        if (!empty($this->type)):

            $this->attributes['type'] = $this->type;

        endif;

        if (!empty($this->name)):

            $this->attributes['name'] = $this->name;

        endif;
        return $this->attributes;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     * @return AbstractElement
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getOptions() {
        return $this->options;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getData() {
        return $this->data;
    }

    public function getValidate() {
        return $this->validate;
    }

    public function getObject_manager() {
        return $this->object_manager;
    }

    public function getError() {

        return $this->error;
    }

    public function setAttribute($key, $value) {

        $this->attributes[$key] = $value;

        return $this;
    }

    public function setAttributes($values) {

        if ($values):

            foreach ($values as $key => $value):

                $this->setAttribute($key, $value);

            endforeach;
        endif;

        return $this;
    }

    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        $this->attributes['value'] = $value;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setValidate($validate) {
        $this->validate = $validate;
        return $this;
    }

    public function setObject_manager($object_manager) {
        $this->object_manager = $object_manager;
        return $this;
    }

    public function setError($error) {

        $this->error = $error;

        return $this;
    }

    public function setValidation($validation) {

        $this->validation = $validation;

        return $this;
    }

    protected function getAttrs() {

        $attr = [];

        if ($this->getAttributes()):

            if (!isset($this->attributes['id'])):

                if (!empty($this->name)):

                    $this->attributes['id'] = $this->name;

                endif;

            endif;

            foreach ($this->attributes as $key => $attribute):

                $attr[] = sprintf(' %s="%s"', $key, $attribute);

            endforeach;

        endif;

        return implode(' ', $attr);
    }

    protected function getAttr($attributes) {

        $attr = [];

        if ($attributes):

            if ($this->exclude):

                foreach ($this->exclude as $exclude):

                    unset($attributes[$exclude]);

                endforeach;

            endif;

            foreach ($attributes as $key => $attribute):

                $attr[] = sprintf(' %s="%s"', $key, $attribute);

            endforeach;

        endif;

        return implode(' ', $attr);
    }

    protected function setLabel($input, $position = 'preppend') {

        $lattributesLabel = [];

        if (isset($this->options['label']) || isset($this->options['option_add'])):

            if (isset($this->options['label_attributes'])):

                $lattributesLabel = $this->options['label_attributes'];

            endif;

            $label = isset($this->options['label'])?$this->options['label']:"";
            $labelAdd = isset($this->options['option_add'])?$this->options['option_add']:"";
            $lattributesLabel['for'] = $this->attributes['id'];

            return $this->partial(sprintf("label-%s", $position), [
                'attr'=>$this->getAttr($lattributesLabel),
                'input'=>$input,
                'label'=>sprintf("%s %s", $label, $labelAdd)
            ]);

        endif;

        return $input;
    }
    /**
     * @param $router
     * @param array $params
     * @return mixed
     */
    public function getRouter($router, $params = [])
    {
        $queryParams = [];

        if(isset($params['query'])):

            $queryParams = $params['query'];

            unset($params['query']);

        endif;

        return $this->router->pathFor($router,$params,$queryParams);
    }


    /**
     * @param mixed $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    abstract public static function getOptionDefault($key, $default=null);

    abstract public function __toString();
}
