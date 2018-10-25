<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:17
 */

namespace Flexe\Table;


abstract class AbstractTable extends AbstractElement
{


    protected $renderer;

    protected $source;

    protected $params;

    protected $headers;

    protected $row;

    protected $data = [];

    protected $headersObjects =[];

    protected $defaultOptions =[];

    protected $tableInit = false;

    abstract public function init();

    abstract public function initFilter($query);

    public function render($type = "html", $template = "custom"){

        if(!$this->tableInit):

            $this->initializable();

        endif;

        switch ($type):

            case 'html':

                return $this->getRender()->html();

                break;

            case 'json':

                return $this->getRender()->json();

                break;

            case 'custom':

                return $this->getRender()->custom($template);

                break;
            default:

                throw new \InvalidArgumentException(sprintf('Invalid type %s', $type));

                break;

        endswitch;

    }

    private function getRender(){

        if (!$this->renderer) {

            $this->renderer = new Render($this);

        }
        return $this->renderer;
    }
    /**
     * Inicializa a table
     */
    private function initializable(){

        $this->table = $this;

        $this->setOptions($this->defaultOptions);

        if(!$this->getParams()):

            throw new \LogicException('Param Adapter is required');

        endif;
        if(!$this->getSource()):

            throw new \LogicException('Source data is required');

        endif;

        $this->tableInit = true;

        if($this->headers):

            $this->setHeaders($this->headers);

        endif;

        $this->init();

        $this->initFilter($this->getSource()->getSelect());

    }




    public function getData(){

        if(!$this->data):

            if(!$this->source):

                throw new \LogicException('Source data is required');

            endif;

            $this->data = $this->source->getData();

        endif;
        return $this->data;
    }

    /**
     * @return Row
     */
    public function getRow(){

        if(!$this->row):

            $this->row = new Row($this);
        endif;

        return $this->row;

    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     * @return AbstractTable
     */
    public function setSource($source)
    {
        $this->source = new Sources\Source($source, $this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }


    /**
     * @param mixed $params
     * @return AbstractTable
     */
    public function setParams($params)
    {
        $this->params = new Params\Params($params);

        $this->params->setTable($this);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getHeader($name)
    {
        if (!count($this->headersObjects)) {

            throw new \LogicException(sprintf('Table hasn\'t got defined headers [%s]', $name));

        }

        if (!isset($this->headersObjects[$name])) {

            throw new \RuntimeException(sprintf('Header name [ %s ] doesnt exist', $name));

        }
        return $this->headersObjects[$name];
    }


    /**
     * @param mixed $headers
     * @return AbstractTable
     */
    public function setHeaders($headers)
    {
        if($headers):

            foreach ($headers as $name => $header):

                $header = new Header($this, $name, $headers);

                $this->headersObjects[$name] = $header;

            endforeach;

        endif;

        return $this;
    }





}