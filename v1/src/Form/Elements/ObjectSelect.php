<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

use Flexe\Db\Init;
use Flexe\Form\Elements\Traits\TargetClassTrait;

/**
 * Description of ObjectSelect
 *
 * @author caltj
 */
class ObjectSelect extends AbstractElement {

    use TargetClassTrait;

    protected $type = 'select';

    protected $template = 'select';

    public function __construct($data, $validation = null) {

        if (isset($data['template'])):

            $this->template = $data['template'];

        endif;

        parent::__construct($data, $validation);

        $this->data = $data;

        $this->name = $data['name'];


        $this->setOptions($data['options']);


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

        /**
         * @var \Flexe\Db\Commons\Queries\Select
         */
        $objectManager = $this->target_class;

        if(is_array($this->getParams())):

            $objectManager->where($this->getParams());

        else:

            if($this->getCriteria()):

                $objectManager->where($this->getCriteria(),$this->getParams());

            endif;

        endif;

        if($this->getNull()){

            $objectManager->where($this->getNull(),null);

        }
        if($this->getNotNull()){

            $objectManager->where(sprintf(" %s IS NOT NULL", $this->getNotNull()));

        }

        if($this->getOrderBy()){

            $objectManager->orderBy($this->getOrderBy());

        }


        $this->options['value_option'] = $objectManager->fetchPairs($this->property, $this->properties);

        $html=[];

        if (!empty($this->value)):

            $this->setAttribute('value', $this->value);

        endif;


        if(isset($this->options['option_empty'])):

            if($this->options['option_empty']):

                $optionHtml[]= $this->partial('option',[

                    'label' => '',

                    'value' => '',

                    'selected' => ''

                ]);
            endif;

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

        if(isset($this->options['option_add'])):

            if(is_array($this->options['option_add'])):

                $labelAdd = $this->partial('option-add',[

                    'route' => $this->options['option_add']['route'],
                    'label' => $this->options['option_add']['label'],
                    'title' => $this->options['option_add']['title'],

                ]);
            else:
                $labelAdd = $this->partial('option-add',[

                    'route' =>  $this->options['option_add']['route'],
                    'label' => "Add",
                    'title' => "Adicionar Novo"

                ]);

            endif;

            $this->options['option_add'] =  $labelAdd;

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

    public function setOptions($options)
    {
        $this->options = $options;

        $this->setObjectManager(new Init());

        $this->setTargetClass($this->getObjectManager()->from($this->options['target_class']));

        $this->setProperty($this->options['property']);

        $this->setProperties($this->options['properties']);

        $this->setFindMethod($this->options['find_method']);

        if(isset($this->options['orderBy'])):

            $this->setOrderBy($this->options['orderBy']);

        endif;
        if(isset($this->options['null'])):

            $this->setNull($this->options['null']);

        endif;
        if(isset($this->options['not_null'])):

            $this->setNotNull($this->options['not_null']);

        endif;


        return $this;

    }
    public function setOptionAdd($options){


        $this->options = array_merge($this->options, [
            'option_add' => array_merge($this->options['option_add'],$options)
        ]);
        return $this;
    }

    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

       return array_get(self::$defaultOptions,sprintf('objectselect.%s',$key),$default);
    }

    public function __toString() {

        return $this->render();
    }

}
