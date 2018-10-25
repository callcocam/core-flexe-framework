<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 10:36
 */

namespace Flexe;


use App\Admin\Model\PermissionModel;
use App\Admin\Model\ResourceModel;
use App\Admin\Model\RoleModel;
use Flexe\Http\Extras\File;
use Flexe\Http\Extras\Get;
use Flexe\Http\Extras\Image;
use Flexe\Http\Extras\Post;
use Flexe\Mail\Mailer\Mailer;
use Flexe\Services\Seo\OpenGraph;
use Flexe\Services\Seo\SEOMeta;
use Flexe\Services\Seo\TwitterCards;
use Flexe\Services\Share;
use Flexe\Services\Tenant;
use Flexe\Storage\Session;
use Flexe\Views\View;
use Slim\Container;

class Dependencies
{

    protected $config = [];

    protected $container;

    /**
     * Dependencies constructor.
     * @param Container $container
     * @param $config
     */
    public function __construct(Container $container, $config)
    {
        $this->container = $container;

        $this->config = $config;

        $this->init();

    }

    private function init(){

        $this->container['config'] = function (){

            return $this->config;

        };



//        $this->container['errorHandler'] = function ($c) {
//            return function ($request, $response, $exception) use ($c) {
//                return $c['response']->withStatus(500)
//                    ->withHeader('Content-Type', 'text/html')
//                    ->write('Something went wrong!');
//            };
//        };

        $this->container['Acl'] = function ($c){


            $ResourceModel = new ResourceModel();

            $Resources = $ResourceModel->from()->findAll();

            $RoleModel = new RoleModel();

            $Roles = $RoleModel->from()->orderBy(' id ASC')->findAll();

            $PermissionModel = new PermissionModel();

            $Permissions = $PermissionModel->from()->select('resources.route')
                ->leftJoin('resources ON resources.id = permissions.resource_id')->findAll();

            $Acl = new Acl\Acl($Resources,$Roles,$Permissions);

            return $Acl;
        };

        $this->container['mailer'] = function($container) {

            $mailer = new Mailer(new View($this->config), [
                'host'      =>  array_get($this->config, 'mail.host'),  // SMTP Host
                'port'      =>  array_get($this->config, 'mail.port'),  // SMTP Port
                'username'  =>  array_get($this->config, 'mail.username'),  // SMTP Username
                'password'  =>  array_get($this->config, 'mail.password'),  // SMTP Password
                'protocol'  =>  array_get($this->config, 'mail.protocol')   // SSL or TLS
            ]);

            // Set the details of the default sender
            $mailer->setDefaultFrom('no-reply@mail.com', 'Webmaster');

            return $mailer;
        };

        $this->container['Post'] = function ($c){

            return new Post($c->request);

        };

        $this->container['Get'] = function ($c){

            return new Get($c->request);

        };


        $this->container['Image'] = function ($c){

            return new Image($c->request);

        };

        $this->container['File'] = function ($c){

            return new File($c->request);

        };

        $this->container['tenant'] = function ($c){

            return new Tenant();

        };


        $this->container['session'] = function ($c){

            return new Session();

        };

        $this->container['Notify'] = function ($c){

            return new Plugins\Notify\Notify();

        };

        $this->container['Share'] = function ($c){

            return new Share($c->get('request'));

        };

        $this->container['SEOMeta'] = function ($c){

            $config = array_get($this->config,'meta');

            $tenant = $c->tenant->getCompany();

            array_set($config,'defaults.title',$tenant['name']);

            return new SEOMeta($config);

        };

        $this->container['OpenGraph'] = function ($c){

            $config = array_get($this->config,'opengraph');

            $tenant = $c->tenant->getCompany();

            array_set($config,'defaults.title',$tenant['name']);

            return new OpenGraph($config);

        };

        $this->container['Twitter'] = function ($c){

            $config = array_get($this->config,'twitter');

            $tenant = $c->tenant->getCompany();

            array_set($config,'defaults.title',$tenant['name']);

            return new TwitterCards($config);

        };


    }
}