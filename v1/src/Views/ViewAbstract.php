<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Flexe\Views;
use Flexe\Menu;
use Flexe\Storage\Session;
use Flexe\Views\Extras\Url;

/**
 * Description of ViewAbstract
 *
 * @author caltj
 */
class ViewAbstract extends Uri {

    protected $navigate;
    /**
     * @var $menu Menu
     */
    protected $menu;

    protected $defaultExt = 'phtml';

    protected $view = 'index';

    protected $data = [];

    protected $dir;

    protected $path;

    protected $layout;

    protected $template;

    protected $terminal = false;

    protected $helpers;

    protected $scripts=[];

    protected $style =[];

    protected $scriptsExtra = [];

    protected $scriptsCount = 0;

    public $content = '';

    public $session;

    public function __construct(array $data = [], $request = null) {

        $this->data = $data;

        $this->layout = config('layout',"layout/template");

        $this->session = Session::factory();
    }

    public function getDefaultExt() {
        return $this->defaultExt;
    }



    public function getView() {
        return $this->view;
    }


    public function getPath() {
        return $this->path;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function getTerminal() {
        return $this->terminal;
    }


    public function setDefaultExt($defaultExt) {
        $this->defaultExt = $defaultExt;
        return $this;
    }

    public function setView($view) {
        $this->view = $view;
        return $this;
    }

    public function setVariable($key,$data) {

        $this->data[$key] = $data;

        return $this;
    }

    public function setVariables($data) {

        if($data):

            foreach ($data as $key => $datum):

                $this->setVariable($key, $datum);

            endforeach;

        endif;

        return $this;
    }

    public function setData($data) {

        $this->data = $data;

        return $this;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
        return $this;
    }

    public function setTerminal($terminal) {
        $this->terminal = $terminal;
        return $this;
    }

    /**
     * @param mixed $template
     * @return ViewAbstract
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function setMenu(Menu $menu){

        $this->menu = $menu;

        return $this;
    }


    public function partial($template, $data = []){

        $file = sprintf("%s%s.%s", $this->path, sprintf("partials/%s",$template), $this->defaultExt);

        if (!file_exists($file)):

            throw new \Exception(sprintf("template %s not found", $file));

        endif;

        $data = array_merge($this->data, $data);

        if ($data):

            extract($data);

        endif;

        ob_start();

        include $file;

        return ob_get_clean();

    }

    protected function getContentFile($file, $data = []) {

        $file = sprintf("%s%s.%s", $this->path, $file, $this->defaultExt);

        if (!file_exists($file)):

            throw new \Exception(sprintf("template %s not found", $file));

        endif;

        $data = array_merge($this->data, $data);

        if ($data):

            extract($data);

        endif;

        ob_start();

        include $file;

        return ob_get_clean();
    }


    public function __get($class)
    {
        $Class = studly($class);

        switch ($Class):

            case class_exists(sprintf(config("helpers.element"),$Class)):

                $html = new \ReflectionClass(sprintf(config("helpers.element"),$Class));

                return $html->newInstance('div');

                break;
            case class_exists(sprintf(config("helpers.admin.select2"),$Class)):

                $html = new \ReflectionClass(sprintf(config("helpers.admin.select2"),$Class));

                return $html->newInstance('div');

                break;
            case class_exists(sprintf(config("helpers.admin.chart"),$Class)):

                $html = new \ReflectionClass(sprintf(config("helpers.admin.chart"),$Class));

                return $html->newInstance('div');

                break;
            case class_exists(sprintf(config("helpers.admin.model"),$Class)):

                $model = new \ReflectionClass(sprintf(config("helpers.admin.model"),$Class));

                return $model->newInstance();

                break;
            case class_exists(sprintf(config("helpers.home"),$Class)):

                $helper = sprintf(config("helpers.home"),$Class);

                $h = new $helper();

                if(!$this->navigate):

                    $this->navigate = new Url($this->menu->getRouter());

                endif;

                $h->setNavigate($this->navigate);

                return $h;

                break;

        endswitch;

        throw new \InvalidArgumentException(sprintf("Class %s not found", studly($class)));
    }




    public function setStyle($style, $attrs = []){

        $attributes = [];

        if($attrs):

            foreach ($attrs as $key => $attr):

                $attributes[] = sprintf(' %s="%s"',$key, $attr);

            endforeach;

        endif;

        $this->style[] = sprintf('<link rel="stylesheet" href="%s" %s>', assest($style), implode(" ", $attributes));

        return $this;
    }

    public function getStyles(){

        return implode(PHP_EOL, $this->style);

    }

    /**
     * @param $script
     * @param bool $exibe
     * @param bool $extra
     * @return $this
     */
    public function setScript($script, $exibe = true, $extra=false){

        if($exibe):
            if($extra):
                $this->scriptsExtra[$this->scriptsCount] = sprintf('<script src="%s"></script>', assest($script));
            else:
                $this->scripts[$this->scriptsCount] = sprintf('<script src="%s"></script>', assest($script));
            endif;
        endif;

        $this->scriptsCount++;

        return $this;
    }

    public function getScripts(){

        $scripts = array_merge($this->scripts, $this->scriptsExtra);

        $this->scripts =[];

        $this->scriptsExtra = [];

        return implode(PHP_EOL, $scripts);

    }

}
