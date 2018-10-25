<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

/**
 * Description of Cover
 *
 * @author caltj
 */
class FilemanagerStandalone extends AbstractElement {

    protected $type = 'text';
    protected $attrImg = '';
    protected $template = 'filemanager-standalone';

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
            
            $this->setAttrImg([
                'src'=>$this->value,
                'id'=>'upload-preview',
                'style'=>'height: 100%; width: 100%; display: block;',
            ]);
            else:
                $this->setAttribute('value',$this->value);
                $this->setAttrImg([
                    'id'=>'upload-preview',
                    'src'=>'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTY0N2I3YjNjZmQgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNjQ3YjdiM2NmZCI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI1OS41NTQ2ODc1IiB5PSI5NC41Ij4xNzF4MTgwPC90ZXh0PjwvZz48L2c+PC9zdmc+',
                    'style'=>'height: 100%; width: 100%; display: block;',
                    'alt'=>'100%x180',
                    'data-src'=>'holder.js/100%x180',
                    'data-holder-rendered'=>'true',
                ]);

        endif;


        $html = [];

        $html['help-block'] = '';


        $html['input'] = $this->partial('input',[
            'attr'=>$this->getAttrs(),
            'help-block'=>'',
        ]);

        if ($this->getError()):

            $html['help-block'] = $this->partial('help-block', [
                'error' => $this->getError()
            ]);

            $has_error = 'has-error';

            $this->setAttribute('class', sprintf("%s %s", $has_error, $this->attributes['class']));

        endif;

        $html['options'] =JsonEncoder(config('plugins.fancybox'));
        $html['params'] = sprintf('/_cdn/plugins/filemanager/dialog.php?type=1&field_id=cover', config('paths.base'));

        return $this->partial($this->template, $html);
    }

    private function setAttrImg($attrs){
        $attrImg = [];
        if($attrs):
            foreach ($attrs as $key => $attr):
                $attrImg[] = sprintf('%s="%s"', $key, $attr);
            endforeach;
        endif;
        $this->attrImg = implode(" ", $attrImg);
    }

    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('filemanager.%s',$key),$default);
    }

    public function __toString() {

        return $this->render();
    }

}
