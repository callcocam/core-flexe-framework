<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 09:40
 */

namespace Flexe;


use Flexe\Table\AbstractTable;
use Slim\App;

class Application
{

    protected $app;

    protected $settings;

    protected $container;

    /**
     * Appliction constructor.
     * @param $settings
     */
    public function __construct($settings)
    {
        $this->settings = $settings;

        $this->app = new App($this->settings);
        $this->app->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    }

    public function run(){

        $this->container = $this->app->getContainer();

        new Dependencies($this->container, $this->settings['settings']);

        if(isset($this->settings['settings']['modules'])):

            $modules = $this->settings['settings']['modules'];

            if($modules):

                foreach ($modules as $module):

                    $this->routes($module['name']);

                    $this->forms($module['name']);

                    $this->models($module['name']);

                    $this->tables($module['name']);

                endforeach;
            endif;
        endif;

        $this->app->run();
    }

    private function routes($module){

        $Routes = $this->load($module, 'Route');

        if($Routes):

            foreach ($Routes as $route):

                $Router = (new \ReflectionClass($route))->newInstance($this->app);

                $Router->create();

            endforeach;
        endif;
    }


    private function forms($module){

        $Forms = $this->load($module, 'Form');

        if($Forms):

            foreach ($Forms as $key => $form):

                $this->container[$key] = function () use ($form){

                    $this->settings['tenant'] = $this->container['tenant'];

                    $Form = (new \ReflectionClass($form))->newInstanceArgs([
                        "AjaxForm",
                        $this->container
                    ]);

                    return $Form;

                };

            endforeach;

        endif;
    }


    private function models($module){

        $Models = $this->load($module, 'Model');

        if($Models):

            foreach ($Models as $key => $model):

                $this->container[$key] = function () use ($model){

                    $Model = (new \ReflectionClass($model))->newInstance();

                    return $Model;

                };

            endforeach;

        endif;
    }



    private function tables($module){

        $Tables = $this->load($module, 'Table');

        if($Tables):

            foreach ($Tables as $key => $table):

                $this->container[$key] = function () use ($table){

                    /**
                     * @var AbstractTable $Table
                     */
                    $Table = (new \ReflectionClass($table))->newInstance();

                    $Table->setRouter($this->container->router);

                    return $Table;

                };

            endforeach;

        endif;
    }

    private function load($module, $sufix = "Route"){

        $dir = dirname(__DIR__, 2);

        $isDir = sprintf("%s/%s/src/%s/%s", $dir, __APP_PROJECT__, $module, $sufix);

        $paths = [];

        if(is_dir($isDir)):

            $dir_iterator = new \RecursiveDirectoryIterator($isDir);

            $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($iterator as $file):

                if($file->isFile()):

                    $R = explode(".", $file->getFileName());
                    //\App\Admin\Route\AdminRoute
                    //\App\Admin\Form\UserForm
                    //dd(sprintf("%s%s",$module, reset($R)));
                    $paths[sprintf("%s%s",$module, reset($R))] = sprintf("\\%s\\%s\\%s\\%s", "App", $module, $sufix, reset($R));
                endif;

            endforeach;

        endif;

        return $paths;
    }

}



































