<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

/**
 * Description of Email
 *
 * @author caltj
 */
class Email extends AbstractElement {

    protected $type = 'email';

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

        if (!empty($this->value)):

            $this->setAttribute('value', $this->value);

        endif;


        $html = [];

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

        $html['attr'] = $this->getAttrs();

        return $this->partial('inline', [
                    'render' => $this->setLabel($this->partial($this->template, $html),$position),
                    'error' => $has_error
        ]);
    }

    public function __toString() {

        return $this->render();
    }
    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('email.%s',$key),$default);
    }
}
