<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 25/08/2018
 * Time: 11:23
 */

namespace Flexe\Helper;


use Flexe\Services\Share;
use Flexe\Storage\Session;

class AbstractHelper
{

    use TraitHelper;

    protected $session;

    protected $model;

    protected $data;

    protected $user;

    protected $navigate;

    /**
     * @var $Share Share
     */
    protected $Share;
    protected $company;

    public function __construct()
    {
        $this->path = sprintf("%s/partials/elements/", dirname(__DIR__, 2));

        if($this->model):
          $this->model = new $this->model;
        endif;

        $this->session = Session::factory();

        $this->user = $this->session->get('user');

    }

    public function html($tag, $text = '', array $attributes = [], $renderHtml = true){

        return new HtmlElement($tag, $text,  $attributes, $renderHtml);
    }

    public function form(){

        return new Form();

    }

    protected function prefix($data,$prefix){
        foreach ($data as $key => $value):
            $data[sprintf("%s-%s",$prefix, $key)] = $value;
        endforeach;
        return $data;
    }

    public function setNavigate($navigate){

        $this->navigate = $navigate;

        return $this;
    }

    /**
     * @param $route
     * @param array $params
     * @return mixed
     */
    public function url($route, $params = []){

        return $this->navigate->url($route,$params);
    }

    protected function users($key=null){

        if($this->user):

            return $this->user[$key];

        endif;

        return $this->user;

    }


    public function gallery($parent, $assets){

        $html_gallery = [];
        $html_nav = [];

        $index = 1;

        $gallerys = $this->model->from('gallerys')->where(
            [
                'parent'=>$parent,

                'assets'=>$assets

            ]
        )->findAll();

        if($gallerys):

            foreach ($gallerys as $gallery):

                $images =  $this->model->from('images')->where(
                    [
                        'parent'=>$gallery['id'],

                        'assets'=>'gallerys'
                    ]
                )->findAll();

                if($images):

                    foreach ($images as $image):

                        $image['index'] = $index;

                        $html_gallery[] = $this->partial('gallery', $image);

                        $html_nav[] = $this->partial('navigate', $image);

                        $index++;

                    endforeach;

                endif;

            endforeach;

        endif;

  return [
            'navigate'=>implode(PHP_EOL, $html_nav),
            'gallery'=>implode(PHP_EOL, $html_gallery)
        ];

    }

    public function setShare($share){

        $this->Share = $share;

        return $this;

    }



    public function setCompany($company){

        $this->company = $company;

        return $this;

    }

    public function getData($key=null){

        if(isset($this->data[0][$key])):

            return $this->data[0][$key];

        endif;

        return $key;


    }

    public function getDatas($key=null){

        if(isset($this->data[$key])):

            return $this->data[$key];

        endif;

        return $this->data;


    }
}