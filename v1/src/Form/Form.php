<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Form;

use Flexe\Form\Elements\Defaults\DateTimePikerTrait;
use Flexe\Form\Elements\Defaults\DateTimeTrait;
use Flexe\Form\Elements\Defaults\DateTrait;
use Flexe\Form\Elements\Defaults\DecimalTrait;
use Flexe\Form\Elements\Defaults\EditorTrait;
use Flexe\Form\Elements\Defaults\EmailTrait;
use Flexe\Form\Elements\Defaults\FilemanagerStandaloneTrait;
use Flexe\Form\Elements\Defaults\FilemanagerTrait;
use Flexe\Form\Elements\Defaults\FileTrait;
use Flexe\Form\Elements\Defaults\HiddenTrait;
use Flexe\Form\Elements\Defaults\ObjectSelectTrait;
use Flexe\Form\Elements\Defaults\PasswordTrait;
use Flexe\Form\Elements\Defaults\SelectTrait;
use Flexe\Form\Elements\Defaults\StatusTrait;
use Flexe\Form\Elements\Defaults\CoverTrait;
use Flexe\Form\Elements\Defaults\SubmitTrait;
use Flexe\Form\Elements\Defaults\TextAreaTrait;
use Flexe\Form\Elements\Defaults\TextTrait;
use Flexe\Form\Elements\Hidden;
use Flexe\Model\AbstractModel;
use Flexe\Storage\Session;
use Flexe\Validate\Validate;
use Flexe\Views\Extras\Url;

/**
 * Description of Form
 *
 * @author caltj
 */
class Form {


    use TextTrait;
    use DecimalTrait;
    use TextAreaTrait;
    use EditorTrait;
    use DateTrait;
    use DateTimeTrait;
    use DateTimePikerTrait;
    use EmailTrait;
    use ObjectSelectTrait;
    use SelectTrait;
    use StatusTrait;
    use CoverTrait;
    use FilemanagerTrait;
    use FilemanagerStandaloneTrait;
    use PasswordTrait;
    use HiddenTrait;
    use SubmitTrait;
    use FileTrait;
    protected $elements = [];
    protected $name;
    protected $data;
    protected $validation;
    protected $attributes = [];
    protected $validate;
    protected $user;
    protected $tenant;
    /**
     * @var array
     */
    private $settings;

    protected $session;

    protected $router;

    public function __construct($name = "AjaxForm", $settings = null) {


        $this->setValidation(new Validate());

        if($settings):

            $this->setTenant($settings['tenant']->getCompany());

            $this->setRouter($settings['router']);

        endif;

        $this->session = Session::factory();

        $this->name = $name;

        $this->settings = $settings;

        $this->getUser();

        $this->add($this->addHidden('id'));
        $this->add($this->addHidden('alias'));
        $this->add($this->addHidden('slug'));

        $this->add($this->setAttributesHidden([
            'value'=>$this->tenant['id']
        ])->addHidden('company_id'));

        $this->add($this->setAttributesHidden([
            'value'=>$this->user['id']
        ])->addHidden('user_id'));

        $this->add($this->addHidden('type'));

        $this->add($this->addHidden('width'));

        $this->add($this->addHidden('folder'));

        $this->add($this->addHidden('template'));


    }

    /**
     * @return mixed
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * @param mixed $tenant
     * @return Form
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;
        return $this;
    }


    /**
     * @return Validate
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param Validate $validation
     * @return Form
     */
    public function setValidation(Validate $validation)
    {
        $this->validation = $validation;
        return $this;
    }


    public function getAttributes() {

        return $this->attributes;
    }

    public function getAttribute($key) {

        if(isset($this->attributes[$key])):

            return $this->attributes[$key];

        endif;

        trigger_error("O attribute {$key} não foi encontrado");

        return $this->attributes;
    }

    public function setAttribute($key, $value) {

        $this->attributes[$key] = $value;

        return $this;
    }

    public function setAttributes($values) {

        if ($values):

            foreach ($values as $key => $value):

                $this->setAttribute($key, $value);

            endforeach;
        endif;

        return $this;
    }

    public function setAction($action) {

        $this->attributes['action'] = $action;

        return $this;
    }
    public function getAction($params=[]) {

            return $this->getRouter($this->attributes['action'],$params);

    }
    public function getName() {

        return $this->name;
    }

    public function setName($name) {

        $this->attributes['name'] = $name;

        return $this;
    }

    public function setData($data) {

        $this->data = $data;

        return $this;
    }

    public function getData() {

        return $this->data;
    }

    /**
     * @param array $array
     * @return $this
     * @throws \Exception
     */
    protected function add(array $array) {

        if (!isset($array['name'])) {

            throw new \Exception("a key name e obrigatoria");
        }
        if (!isset($array['type'])) {

            throw new \Exception("a key type e obrigatoria");
        }

        $this->elements[$array['name']] = $array;

        return $this;
    }

    /**
     * @param $name
     * @return mixed|object
     * @throws \Exception
     */
    public function get($name) {

        if (!isset($this->elements[$name])) {

            throw new \Exception("filed name {$name} não foi encontrado");
        }

        if (class_exists($this->elements[$name]['type'])) {

            $reflection = new \ReflectionClass($this->elements[$name]['type']);
            /**
             * @var $Eelement AbstractElement
             */
            $Eelement = $reflection->newInstanceArgs([$this->elements[$name], $this->validation]);

            if (isset($this->data[$name])):

                if(isset($this->data['id'])):

                    $Eelement->setId($this->data['id']);

                endif;
                $Eelement->setValue($this->data[$name]);

            endif;

            $Eelement->setRouter($this->router);

            $Eelement->setError($this->getError($name));

            return $Eelement;
        }

        return $this->elements[$name];
    }

    public function isValid(){


        if($this->data):

            foreach ($this->data as $key => $value){


                $this->get($key);

            }

            return $this->validation->validateFields($this->data);

        endif;

        return false;
    }

    public function getError($name) {

        $errors = $this->validation->getValidationErrors();

        if(isset($errors[$name])):

            return $errors[$name];

        endif;

        return null;
    }

    public function getErrors() {

        return $this->validation->getValidationErrors();
    }

    /**
     * @param $router
     * @param array $params
     * @return mixed
     */
    public function getRouter($router, $params = [], $queryParameters=[])
    {

        return $this->router->url($router,$params, $queryParameters);
    }

    /**
     * @param mixed $router
     */
    public function setRouter($router)
    {
        $this->router = new Url($router);
    }

    protected function getConnect() {

        return new AbstractModel();
    }

    protected function getUser() {

        if(!$this->user):

            $this->user = (new Session())->get('user');

        endif;

        return $this->user;
    }

}
