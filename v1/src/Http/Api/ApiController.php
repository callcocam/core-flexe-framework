<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 09/09/2018
 * Time: 11:41
 */

namespace Flexe\Http\Api;


use Slim\Http\Request;
use Slim\Http\Response;

abstract class ApiController
{

    protected $container;

    protected $table;

    protected $model;

    protected $validate;

    protected $data;

    protected $route = "admin";

    protected $controller = "admin";

    protected function load()
    {

        $this->company = $this->tenant->getCompany();

        $this->data = array_merge(
            $this->Get->getParams(),
            $this->Post->getParams(),
            $this->Image->getImage()
        );

        if(class_exists($this->model)):

            $this->model = $Model = (new \ReflectionClass($this->model))->newInstance();

        endif;

        if(class_exists($this->table)):

            $this->table = (new \ReflectionClass($this->table))->newInstance();

        endif;

        if(class_exists($this->validate)):

            $this->validate = (new \ReflectionClass($this->validate))->newInstance($this->data);

        endif;

    }

    public function __get($name)
    {
        if($this->container->has($name)):

            return $this->container->get($name);

        endif;

        return $name;
    }

    public function listar(Request $request, Response $response, $args = []){

        $data = [];
        if($this->table && $this->model):

            $params = $this->Get->getParams();

            $params['route'] = $this->route;

            $params['controller'] = $this->controller;

            $data = $this->table->setSource($this->model)->setParams($params)->render('json');

        endif;


        return $response->withJson($data);
    }


    public function view(Request $request, Response $response, $args = []){

        return $response->withJson($this->model->from()->where([
            'alias'=>$args['id']
        ])->find());
    }
}