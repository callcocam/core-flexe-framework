<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 13/09/2018
 * Time: 10:36
 */

namespace Flexe\Form\Elements;


use Flexe\Model\AbstractModel;

class File extends AbstractElement
{
    protected $type = "file";

    protected $template = 'files';

    public function __construct($data, $validation=null)
    {
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
    }

    public function render(){

        if(!empty($this->value)):

            $this->setAttribute('value',$this->value);

        endif;

        $html = [];

        $html['help-block'] = '';


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


        $html['files']=$this->getFiles();
        $html['attr'] = $this->getAttrs();

        return $this->setLabel($this->partial($this->template, $html),$position);
    }

    private function getFiles(){

        $html = [];

        $Filtro = explode(",", $this->value);

       if(!$Filtro):

           return "";

       endif;

        $Model = new AbstractModel();

        $Query  = $Model->from('files');

        $Query->where('id', $Filtro);

        $Files = $Query->findAll();

        if($Files):

            foreach ($Files as $file):

                $file['btn'] = $this->partial('../buttons/btn',[

                    'attr'=>$this->setAttr([

                        'class'=>'delete btn btn-danger',

                        'href'=>sprintf("/admin/file/excluir/%s",$file['id'])

                    ]),
                    'icon'=>$this->partial('../buttons/icon',[

                         'icon'=>'fa fa-trash'
                    ]),
                    'context'=>''
                ]);

                $html[] = $this->partial('file-row', $file);

            endforeach;

            return $this->partial('files-body',[
                'rows'=>implode(PHP_EOL, $html)
            ]);

        endif;

        return '';

    }

    /**
     * @param $attrs
     * @return string
     */
    private function setAttr(array $attrs){
        $attribute = [];
        if($attrs):
            foreach ($attrs as $key => $attr):
                $attribute[] = sprintf('%s="%s"', $key, $attr);
            endforeach;
        endif;
        return implode(" ", $attribute);
    }

    public function __toString()
    {
        return $this->render();
    }
    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('file.%s',$key),$default);
    }
}