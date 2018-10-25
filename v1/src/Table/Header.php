<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:17
 */

namespace Flexe\Table;


class Header extends AbstractElement
{


    protected $options=[];

    protected $index = '';

    protected $name = '';

    protected $headers;

    protected $title = '';

    protected $width = '';

    protected $oder = 'DESC';

    protected $alias = '';

    protected $cell;

    protected $sortable = true;

    protected static $orderReverse = [
        'asc' => 'desc',
        'desc' => 'asc'
    ];


    public function __construct($table, $index, $headers)
    {

        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

        $this->index = $index;

        $this->headers = $headers;

        $this->cell = new Cell($this);

        $this->cell->setTable($table);

        $this->setTable($table);

        $this->init();

    }

    private function init(){

        if($this->headers):

            foreach ($this->headers as $name => $header):

                $this->options[$name] = $header;

            endforeach;

        endif;

    }

    /**
     * @return Cell
     */
    public function getCell(): Cell
    {
        return $this->cell;
    }
    /**
     * Init header (like asc, desc, column name )
     */
    protected function initRendering()
    {
        $paramColumn = $this->getTable()->getParams()->column;
        $paramOrder = $this->getTable()->getParams()->order;
        $order = ($paramColumn == $this->name) ? self::$orderReverse[$paramOrder] : 'asc';

        if ($this->sortable) {
            $classSorting = ($paramColumn == $this->name)
                ? 'sorting_' . self::$orderReverse[$paramOrder] : 'sorting';
            $this->setAttribute('class', sprintf("%s sortable", $classSorting));
            $this->setAttribute('data-order', $order);
            $this->setAttribute('data-column', $this->title);
        }

        if (isset($this->options[$this->index]['width']) && $this->options[$this->index]['width']) {
            $this->setAttribute('width', $this->options[$this->index]['width']);
        }
    }

    /**
     * Rendering header element
     *
     * @return string
     */
    public function render()
    {
        $this->initRendering();

        $render = $this->options[$this->index]['title'];
        if(isset($this->options[$this->index]['visible'])):

            if(!$this->options[$this->index]['visible']):

                return '';

            endif;

        endif;
        foreach ($this->decorators as $decorator) {

            $render = $decorator->render(translate($render));

        }

        return $this->partial('cell', [

            'tag'=>'th',
            'content'=>$render,
            'attr'=>$this->getAttrs()

        ]);
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }
}
















