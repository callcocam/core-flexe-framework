<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

/**
 * Description of Hidden
 *
 * @author caltj
 */
class Hidden extends AbstractElement {

    protected $type = 'hidden';

    public function __construct($data, $validation = null) {

        if (isset($data['template'])):

            $this->template = $data['template'];

        endif;

        parent::__construct($data, $validation);

        $this->data = $data;

        $this->name = $data['name'];

        if (isset($data['attributes'])):

            if (isset($data['attributes']['value'])):

                $this->setValue($data['attributes']['value']);

            endif;

            $this->setAttributes($data['attributes']);

        endif;



    }

    public function render() {

        if (!empty($this->value)):

            $this->setAttribute('value', $this->value);

        endif;


        $html = [];

        $html['help-block'] = '';

        $html['attr'] = $this->getAttrs();

        return $this->partial('input', $html);
    }

    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('hidden.%s',$key),$default);
    }

    public function __toString() {

        return $this->render();
    }

}
