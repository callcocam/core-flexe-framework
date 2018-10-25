<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Flexe\Views;

use Flexe\Helper\Alert;
use Flexe\Helper\Form;
use Flexe\Helper\InputElement;
use Flexe\Helper\Notify;
use Flexe\Views\Extras\Url;

/**
 * Description of View
 *
 * @author caltj
 */
class View extends ViewAbstract {


    /**
     * @param $route
     * @param array $params
     * @return mixed
     */
    public function url($route, $params = [],$queryParameters=[]){

        $this->navigate = new Url($this->menu->getRouter());

        return $this->navigate->url($route,$params,$queryParameters);
    }

    public function input($element){

        return new InputElement($element);

    }

    public function helper($name){

        return $this->$name;

    }

    public function html($tag, $text = '', array $attributes = [], $renderHtml = true){

        if(!class_exists("\\Flexe\\Helper\\HtmlElement")):

            throw new \InvalidArgumentException("Class \\Flexe\\Helper\\HtmlElement not found");

        endif;

        $html = new \ReflectionClass("\\Flexe\\Helper\\HtmlElement");

        return $html->newInstanceArgs([$tag, $text,  $attributes, $renderHtml]);
    }

    public function model($model){

        if(!class_exists($model)):

            throw new \InvalidArgumentException("Class {$model}");

        endif;

        $Model = new \ReflectionClass($model);

        return $Model->newInstance();
    }


    public function menu(){

        return $this->menu;

    }

    public function acl(){

        return $this->menu->getAcl();

    }
    public function form(){

        return new Form();
    }


    public function notify(){

        return new Notify();

    }

    public function alert(){

        return new Alert();

    }

    public function setHistorys(array $values){

        foreach ($values as $key => $value):

            $this->session->set($key,$value);

        endforeach;

    }

    public function setHistory($key,$value){

        $this->session->set($key,$value);

    }

    public function getHistory($callback){

        return $this->session->get($callback);

    }


    public function render(){

        if(empty($this->template)):

            $this->path = sprintf("%s/%ssrc/%s/views/%s/", __APP_DIR__, __APP_PROJECT__,
                studly_case(title_case($this->route)),
                str_slug($this->controller));

            $this->content = $this->getContentFile($this->action);

        else:
            $this->path = sprintf("%s/%ssrc/%s/views/", __APP_DIR__, __APP_PROJECT__,
                studly_case(title_case($this->getRoute())));
            $this->content = $this->getContentFile($this->template);
        endif;



        if($this->terminal):

            return $this->content;

        endif;

        $this->path = sprintf("%s/%ssrc/views/", __APP_DIR__, __APP_PROJECT__);

        return $this->getContentFile($this->layout);

    }

    public function front($template, $data = []){

        if(empty($this->path)):

            $this->setPath(sprintf("%s/%ssrc/views/", __APP_DIR__, __APP_PROJECT__));

        endif;

        return parent::partial($template, $data);
    }

    public function partial($template, $data = []){

        $this->setPath(sprintf("%s/%ssrc/views/", __APP_DIR__, __APP_PROJECT__));

        return parent::partial($template, $data);
    }

}
