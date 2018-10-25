<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 13:22
 */

namespace Flexe\Views;


class Uri
{

    protected $route = null;

    protected $controller = null;

    protected $action = null;

    protected $id = null;

    protected $defaultRoutes = [];



    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return Uri
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     * @return Uri
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return Uri
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     * @return Uri
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }




    private function setDefault($index, $array, $key, $default = null){

        if(is_null($this->defaultRoutes[$index])):

            $this->defaultRoutes[$index] = array_get($array, $key, $default);

        endif;
    }
}