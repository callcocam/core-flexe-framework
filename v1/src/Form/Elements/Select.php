<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

/**
 * Description of Select
 *
 * @author caltj
 */
class Select extends AbstractElement {

    protected $type = 'select';

    protected $template = 'select';

    public function __construct($data, $validation = null) {

        if (isset($data['template'])):

            $this->template = $data['template'];

        endif;

        parent::__construct($data, $validation);

        $this->data = $data;

        $this->name = $data['name'];

        $this->validation = $validation;

        if (isset($data['attributes'])):

            if (isset($data['attributes']['value'])):

                $this->setValue($data['attributes']['value']);

            endif;

            $this->setAttributes($data['attributes']);

        endif;
        if(isset($data['validate']) && $this->validation){

            if($data['validate']){

                $this->validation->setValidation($this->name,$data['validate']);

            }

        }

        if (isset($data['options'])):

            $this->options = $data['options'];

        endif;



    }

    public function render() {

        $optionHtml=[];

        $html=[];
        if(isset($this->options['option_empty'])):

            if($this->options['option_empty']):

                $optionHtml[]= $this->partial('option',[

                    'label' => $this->options['option_empty'],

                    'value' => '',

                    'selected' => ''

                ]);
            endif;

        endif;

        if (!empty($this->value)):

            $this->setAttribute('value', $this->value);

        endif;
        $selected="";
        if(isset($this->options['value_option'])):

            if($this->options['value_option']):

                $value_options = $this->options['value_option'];

                foreach ($value_options as $key => $option):

                    if($this->value == $key):

                        $selected=" selected";

                    endif;

                    $optionHtml[]= $this->partial('option',[

                        'label' => $option,

                        'value' => $key,

                        'selected' => $selected,

                    ]);

                    $selected="";

                endforeach;

            endif;

        endif;

        $html['options'] = implode(PHP_EOL, $optionHtml);

        $html['help-block'] = '';

        $has_error = 'has-success';

        if ($this->getError()):

            $html['help-block'] = $this->partial('help-block', [
                'error' => $this->getError()
            ]);

            $has_error = 'has-error';

            $this->setAttribute('class', sprintf("%s %s", $has_error, $this->attributes['class']));

        endif;

        $position = 'preppend';

        if(isset($this->attributes['position'])):

            $position = $this->attributes['position'];

        endif;

        unset($this->attributes['type']);

        $html['attr'] = $this->getAttrs();

        return $this->partial('inline', [
            'render' => $this->setLabel($this->partial($this->template, $html),$position),
            'error' => $has_error
        ]);
    }

    public function setValueOptions($options){

        $this->options['value_option'] = $options;

        return $this;
    }

    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('select.%s',$key),$default);
    }

    public function __toString() {

        return $this->render();
    }

}
