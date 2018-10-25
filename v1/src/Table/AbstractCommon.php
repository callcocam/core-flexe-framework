<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:16
 */

namespace Flexe\Table;


use Flexe\Helper\TraitHelper;
use Flexe\Storage\Session;
use Flexe\Views\Extras\Url;

class AbstractCommon
{

    use TraitHelper;


    protected $navigate;

    protected $theme;

    protected $table;

    protected $router;

    protected $session;

    protected $options;

    public function getHistory($callback){

        if(!$this->session instanceof Session):

            $this->session = Session::factory();

        endif;

        return $this->session->get($callback);

    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     * @return AbstractCommon
     */
    public function setTheme($theme)
    {
        if(substr($theme,-1) !="/"):

            $theme = sprintf("%s/", $theme);

        endif;

        $this->theme = $theme;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     * @return AbstractCommon
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param mixed $router
     * @return AbstractCommon
     */
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    public function url($route, $params = [], $queryParameters = []){
        if(!$this->getRouter())
            return "";

        if(!$this->navigate):

            $this->navigate = new Url($this->getRouter());

        endif;

        return $this->navigate->url($route, $params,$queryParameters);
    }
    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     * @return AbstractTable
     */
    public function setOptions($options)
    {
        $this->options = new Options\Option($options);
        return $this;
    }


}