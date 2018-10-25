<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 11:17
 */

namespace Flexe\Http;


use Flexe\Db\Commons\Queries\Delete;
use Flexe\Db\Commons\Queries\Insert;
use Flexe\Db\Commons\Queries\Update;
use Flexe\Form\DeleteForm;
use Flexe\Menu;
use Flexe\Model\AbstractModel;
use Flexe\Plugins\Excel\Fast;
use Flexe\Views\View;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Controller
{

    protected $Render;

    protected $TemplateRender = "html";

    protected $Alert;

    protected $container;

    protected $company;

    protected $user;

    protected $table;

    protected $model;

    protected $form;

    protected $data;

    protected $route = 'admin';

    protected $controller = 'admin';

    protected $action = 'index';

    protected $actionEditar = 'editar';

    protected $id = null;

    protected $status = 'status';

    protected $response;

    abstract public function __construct(Container $container);


    protected function load()
    {

        $menu = new Menu($this->container->get('router'));

        $this->Render = new View($this->config);

        $menu->setAcl($this->container->get('Acl'));

        $this->Render->setRoute($this->route);

        $this->Render->setController($this->controller);

        $this->Render->setAction($this->action);

        $this->Render->setMenu($menu);

        $this->Alert = $this->container->get('Notify');

        $this->company = $this->tenant->getCompany();

        $this->Render->setVariable('company', $this->company);

        $this->data = array_merge(
            $this->Post->getParams(),
            $this->Image->getImage($this->controller),
            $this->File->getFile($this->controller)
            );

        if($this->request->isXhr()):

            $this->Render->setTerminal(true);

        endif;

        $this->user = $this->session->get('user');

        $this->Render->setVariable('title', sprintf("%s - %s",$this->company['name'], config(sprintf('modules.%s.apps.%s.title', title_case($this->route),$this->controller),$this->controller)));

        $this->Render->setVariable('user', $this->user);

        $this->Render->setVariable('route', $this->route);

        $this->Render->setVariable('controller', $this->controller);

        $this->Render->setVariable('action', $this->action);

        $this->Render->setVariable('acl', $this->Acl);

        $this->Render->setVariable('Share', $this->Share);
        $this->Render->setVariable('SEOMeta', $this->SEOMeta);
        $this->Render->setVariable('OpenGraph', $this->OpenGraph);
        $this->Render->setVariable('Twitter', $this->Twitter);

        $this->Render->setVariable('notify', $this->Alert);

        $this->Render->setVariable('queryParams', $this->Get->getParams());

        $this->response = $this->container['response'];
    }

    public function __get($name)
    {
        if($this->container->has($name)):

            return $this->container->get($name);

        endif;

        return $name;
    }

    public function index(Request $request, Response $response, $args = []){

         return $this->Render->render();
    }

    public function export(Request $request, Response $response, $args = []){

        // Load users
        $list = collect($this->model->from()->findAll());
       // Export all users
        $result = (new Fast($list))->export(sprintf('../data/exel/%s-%s.xlsx', $this->controller,date('Y-m-d-H-i-s')));

        return $result;
    }

    public function import(Request $request, Response $response, $args = []){

        // Load users
        $list = collect($this->model->from()->findAll());
       // Export all users
        $result = (new Fast)->import('../data/exel/Modelo-Decolar.xlsx', function ($line) {
           dd($line);
        });
        return $result;
    }


    public function listar(Request $request, Response $response, $args = []){



        if($this->table && $this->model):

            $params = $this->Get->getParams();

            $params['route'] = $this->route;

            $params['controller'] = $this->controller;

             $data = $this->table->setSource($this->model)->setParams($params)->render($this->TemplateRender);

             $this->Render->setVariables($data);

        endif;

        return $this->Render->render();
    }


    public function view(Request $request, Response $response, $args = []){

        $this->valideate_action($request,$response,$args);

        $this->Render->setVariable('data', $this->data);

        $this->Render->setVariable('args', $args);

        $this->form->setData($this->data);

        $this->Render->setAction('view');

        return $this->Render->render();
    }


    public function editar(Request $request, Response $response, $args = []){

        $this->valideate_action($request,$response,$args);

        if(!$this->form):

            $this->Render->setAction('index');

            $this->Alert->info('Nenhum form valido foi passado!!!');

            return $this->create($request, $response, $args);

        endif;

        $this->Render->setAction($this->actionEditar);

        if(isset($this->data['template'])):

              $this->Render->setAction($this->data['template']);

        endif;

        $this->form->setData($this->data);

        $this->Render->setVariable('form', $this->form);

        $this->Render->setVariable('data', $this->data);

        $this->Render->setVariable('args', $args);

        return $this->Render->render();
    }


    public function create(Request $request, Response $response, $args = []){

        if(!$this->form):

            $this->Render->setAction('index');

            $this->Alert->info('Nenhum form valido foi passado!!!');

            return $this->listar($request, $response, $args);

        endif;

        $this->Render->setAction($this->actionEditar);

        if(isset($this->data['template'])):

            $this->Render->setAction($this->data['template']);

        endif;

        $this->Render->setVariable('args', $args);

        $this->Render->setVariable('form', $this->form);

        return $this->Render->render();
    }

    public function excluir(Request $request, Response $response, $args = []){

        $this->form =new DeleteForm("AjaxForm", $this->container);

        if($this->Post->isPost()):

            $this->form->setData($this->data);

            if($this->form->isValid()):

                $Model = $this->model->delete(null,$this->data['id']);

                if($Model instanceof Delete):

                    $Result = $Model->execute();

                else:

                    $Result = $Model;

                endif;

                if($Result):

                    $this->Render->setAction('index');

                    $this->Alert->success(config('messages.delete.succes','Registro excluido Com Sucesso!!'));

                    return $this->listar($request, $response, $args);

                else:

                    if($this->session->exists('error')):

                        $this->Alert->info($this->session->get('error'));

                        $this->session->clear();

                    else:

                        $this->Alert->info(config('messages.delete.succes','Não Foi Possivel Finalizar A Operação!!!'));

                    endif;

                endif;

            endif;

        endif;

        $this->valideate_action($request, $response, $args);

        $this->form->setAttribute('action', sprintf("%s.%s.excluir", str_slug($this->route), $this->controller));

        $this->Render->setVariable('callback', sprintf("%s.%s", str_slug($this->route), $this->controller));

        $this->Render->setVariable('form', $this->form);

        $this->Render->setVariable('args', $args);

        $this->Render->setAction('excluir');

        $this->form->setData($this->data);

        return $this->Render->render();
    }

    public function status(Request $request, Response $response, $args = []){

        $this->data = $this->Get->getParams();

        $Model = $this->model->update(null, $this->model->exchangeArray( $this->data), $args['id']);

        if($Model instanceof Update):

            $Result = $Model->execute();

        else:

            $Result = $Model;

        endif;

        return $response->withJson($Result);
    }
    public function save(Request $request, Response $response, $args = []){

        $this->Render->setAction('editar');

        if(!$this->form):

            $this->Alert->info(config('message.error.form','Nenhum formulario valido foi passado!!!'));

            return $this->create($request, $response, $args);

        endif;

        if(isset($this->data[$this->status])){

            $this->data[$this->status] = 1;

        }
        else{

            $this->data[$this->status] = 0;

        }

        $this->data['company_id'] = $this->company['id'];

        $this->form->setData($this->data);

        if($this->form->isValid()):

            if(isset($this->data['id']) && (int)$this->data['id']):

                $Model = $this->model->update(null, $this->model->exchangeArray($this->data), $this->data['id']);

                if($Model instanceof Update):

                    $Result = $Model->execute();

                else:

                    $Result = $Model;

                endif;

                if($Result):

                    $this->Alert->success(config('messages.update.success','Registro Atulazido Com Sucesso!!'));

                else:

                    if($this->session->exists('error')):

                        $this->Alert->info($this->session->get('error'));

                        $this->session->clear('error');

                    else:

                        $this->Alert->info(config('message.error.update','Não Foi Possivel Finalizar A Operação!!!'));

                    endif;


                endif;

            else:

                $Model = $this->model->insert(null, $this->model->exchangeArray($this->data));

                if($Model instanceof Insert):

                    $Result = $Model->execute();
                else:
                    $Result = $Model;
                endif;

                if($Result):

                    $this->data['id'] = $Result;

                    $this->Alert->success(config('message.success.insert','Registro Cadastrado Com Sucesso!!'));

                else:

                    if($this->session->exists('error')):

                        $this->Alert->info($this->session->get('error'));

                        $this->session->clear('error');

                    else:

                       $this->Alert->info(config('message.error.insert','Não Foi Possivel Finalizar A Operação!!!'));

                    endif;

                endif;

            endif;


        endif;

        if(isset($this->data['template'])):

            $this->Render->setAction($this->data['template']);

        endif;

        $this->form->setData($this->data);

        $this->Render->setVariable('form', $this->form);

        $this->Render->setVariable('args', $args);

        $this->Render->setVariable('data', $this->data);

        return $this->Render->render();
    }

    private function valideate_action($request, $response, $args){

        if(!$args['id']):

            $this->Render->setAction('index');

            $this->Alert->danger('message.error.id','Nenhum identificador valido foi passado!!!');

            return $this->listar($request, $response, $args);

        endif;

        if(!$this->model):

            $this->Render->setAction('index');

            $this->Alert->info('message.error.model','Nenhum model valido foi passado!!!');

            return $this->listar($request, $response, $args);

        endif;


        $this->data = $this->model->from(null,$args['id'])->find();

        if(!$this->data):

            $this->Render->setAction('index');

            $this->Alert->info(config('masseges.error.dada','Nenhum dado valido foi encontrado!!!'));

            return $this->listar($request, $response, $args);

        endif;
    }

    public function toRoute($url,$args=[],$params = []){

        return $this->router->pathFor($url,$args,$params);
    }

    protected function redirect($url,$params=[]){

        $queryParams=[];

        if(isset($params['query'])){

            $queryParams = $params['query'];

            unset($params['query']);
        }

        return $this->response->withRedirect($this->router->pathFor($url,$params,$queryParams));

    }
}