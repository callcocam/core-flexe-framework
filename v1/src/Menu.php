<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 16:23
 */

namespace Flexe;


use Flexe\Acl\Privileges;
use Flexe\Helper\AbstractHelper;
use Flexe\Storage\Session;

class Menu extends AbstractHelper
{

    /**
     * @var $acl \Flexe\Acl\Zend\Acl
     */
    protected $acl;

    protected $router;

    protected $user;

    protected $html = [];

    protected $route;

    protected $prefix = '';

    protected $active = '';

    protected $query = [];

    protected $queryString =[];

    protected $sub = '';

    protected $permission = true;

    protected $path;

    protected $defaultExt = 'phtml';

    protected $attrs = [];

    protected $data;

    public function __construct($router)
    {
        $this->router = $router;

        parent::__construct();

        $this->user = (Session::factory())->get('user');

        $this->path = sprintf("%s/%ssrc/views/partials/menus/%s", __APP_DIR__, __APP_PROJECT__, __THEME__);
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
     * @return Menu
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param $route
     * @param $text
     * @param string $icone
     * @return string
     * @throws \Exception
     */
    public function init( $route, $text, $icone='fa fa-arrow-right'){

        $this->route = $route;

        if($this->permission):

            $this->data['prefix'] = $this->prefix;

            $this->attrs['href'] = $this->router->pathFor($route,
                $this->query,
                $this->queryString
            );

            $this->data['text'] = $text;

            $this->data['route'] = $route;

            $this->data['active'] = $this->active;

            $this->data['icone'] = $icone;

            $this->data['attr'] = $this->getAttrs();

            $this->query = [];

            $this->queryString = [];

            $this->prefix = '';

            $this->active = '';

            $this->html[] = $this->partial(sprintf("%smenu", $this->sub), $this->data);

            $this->data['attr'] = '#';

        endif;

        $this->permission= true;

        return $this;
    }

    /**
     * @param array $query
     * @return Menu
     */
    public function setQuery(array $query): Menu
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param array $queryString
     * @return Menu
     */
    public function setQueryString(array $queryString): Menu
    {
        $this->queryString = $queryString;
        return $this;
    }

    /**
     * @param string $prefix
     * @return Menu
     */
    public function setPrefix(string $prefix): Menu
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @param string $title
     * @return Menu
     */
    public function setTitle(string $title): Menu
    {
        $this->attrs['title'] = $title;
        return $this;
    }

    /**
     * @param string $active
     * @return Menu
     */
    public function setActive(string $active): Menu
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @param string $sub
     * @return Menu
     */
    public function setSub(string $sub): Menu
    {
        $this->sub = $sub;
        return $this;
    }

    public function permissions($router,$action){


        if ($this->acl->hasResource($router)) {

            $this->permission = $this->acl->isAllowed((string)$this->user['role_id'],$router, $action);

        }

         return $this;
    }


    public function print($view="sub-menu", $text="", $icone="")
    {
        $this->permission = true;
        if($this->html):
            $html = $this->html;
            $this->sub = '';
            $this->data['id'] = str_slug(empty($text)?$this->data['text']:$text);
            $this->data['text'] = empty($text)?$this->data['text']:$text;
            $this->data['icone'] = empty($icone)?$this->data['icone']:$icone;
            $this->data['sub-menu'] = implode(PHP_EOL, $html);
            $this->data['attr'] = $this->getAttrs();
            $this->html =[];
            return $this->partial(sprintf("%s", $view), $this->data);
        endif;
        return '';
    }

    public function setAcl($acl){

        $this->acl = $acl;

        return $this;
    }

    public function getAcl(){

        return $this->acl;

    }

    private function setAttrs($attrs){

       if($attrs):

            foreach ($attrs as $key => $attr):

               $this->setAttr($key, $attr);

            endforeach;

        endif;

        return $this;

    }

    public function setAttr($key, $value){

        $this->attrs[$key] = $value;

        return $this;
    }

    private function getAttrs(){

        $attrs = [];

        if($this->attrs):

            foreach ($this->attrs as $key => $attr):

                $attrs[] = sprintf(' %s="%s"', $key, $attr);

            endforeach;

        endif;

       // $this->attrs = [];

        return implode(" ", $attrs);

    }

}