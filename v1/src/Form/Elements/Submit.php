<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 25/08/2018
 * Time: 12:42
 */

namespace Flexe\Form\Elements;


class Submit extends AbstractElement
{

    protected $type = 'submit';

    protected $icon;

    protected $content;

    protected $template = 'submit';

    public function __construct($data, $validation = null) {

        if (isset($data['template'])):

            $this->template = $data['template'];

        endif;

        parent::__construct($data, $validation);

        $this->data = $data;

        $this->name = $data['name'];

        $this->validation = $validation;

        if (isset($data['icon'])):

            $this->icon = $data['icon'];

        endif;

        if (isset($data['attributes'])):

            if (isset($data['attributes']['value'])):

                $this->setValue($data['attributes']['value']);

            endif;

            if (isset($data['attributes']['content'])):

                $this->setContent($data['attributes']['content']);

                unset($data['attributes']['content']);

            endif;

//            $this->setAttribute('type', 'submit');
            $this->setAttributes($data['attributes']);

        endif;

    }

    public function render()
    {

        $html = [];

        $html['content'] = '';

        if(!empty($this->content)):

            $html['content'] = $this->content;

        endif;

        $html['attr'] = $this->getAttrs();

        $html['icon'] = $this->partial('icon', [

            'icon'=>$this->icon

        ]);

        return $this->partial($this->template, $html);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Submit
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public static function getOptionDefault($key, $default = null)
    {
        if(!self::$defaultOptions)
            self::$defaultOptions = config('form.element');

        return array_get(self::$defaultOptions,sprintf('submit.%s',$key),$default);
    }

    public function __toString()
    {
        return $this->render();
    }
}