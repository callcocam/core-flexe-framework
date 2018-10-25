<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form\Elements;

/**
 * Description of TextArea
 *
 * @author caltj
 */
class Editor extends AbstractElement {

    protected $type = '';

    protected $template = 'editor';

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

        $html['value'] = $this->value;

        unset($this->attributes['value']);

        $html['attr'] = $this->getAttrs();

        $this->options();

        return $this->partial('inline', [
            'render' => $this->partial($this->template, $html),
            'error' => $has_error
        ]);
    }


    private function options(){

        $options = [
            'selector'=>'.editor',
            'language'=> 'pt_BR',
           'menubar'=> false,
            'theme'=> "modern",
            'height'=> 450,
            'skin'=> 'lightgray',
            'entity_encoding'=> "raw",
            'theme_advanced_resizing'=> true,
            'plugins'=> [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table directionality emoticons paste textcolor responsivefilemanager youTube code"
            ],
            'toolbar'=> "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | link unlink anchor | image media | forecolor backcolor  | print preview responsivefilemanager youTube code ",
            'image_advtab'=> true ,
            'relative_urls'=> false,
            'theme_advanced_blockformats'=> "h1,h2,h3,h4,h5,p,pre",
            'external_filemanager_path'=>sprintf("%s_cdn/plugins/filemanager/", config('paths.base')),
            'filemanager_title'=>"File Manager" ,
            'external_plugins'=> [ 'filemanager'=> config("%s_cdn/plugins/filemanager/plugin.min.js",config('paths.base') )]
        ];
        file_put_contents(sprintf("%s/%s/%s/_cdn/plugins/tinymce/config.json",
            __APP_DIR__,
            config("paths.public"),
            config("files.path")
        ), JsonEncoder($options));
    }
    public function __toString() {

        return $this->render();
    }
    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('editor.%s',$key),$default);
    }
}
