<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 21:28
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class BtnDecorator extends AbstractCellDecorator
{

    protected $attr = [];

    protected $vars;

    protected $route;

    /**
     * LinkCell constructor.
     * @param $options
     */
    public function __construct(array $options = [])
    {
        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

        $this->options = $options;

        if(!isset($this->options['route'])):

            throw new \InvalidArgumentException('route key in options argument required');

        endif;

        if(isset($this->options['attr'])):

            $this->attr = $this->options['attr'];

        endif;

        $this->route = $this->options['route'];

    }


    public function render($context)
    {

        $actualRow = $this->getActualRow();

        $this->vars['context'] = '';

        if(!isset($this->attr['class'])):

            $this->attr['class'] = 'navigate btn btn-success btn-sm';

        else:

            $this->attr['class'] = sprintf('navigate %s',$this->attr['class']);

        endif;

        if(!isset($this->attr['title'])):

            $this->attr['title'] = "Manuteção";

        endif;

        $params=[];


        if(isset($this->options['queryParams'])):

            foreach ($this->options['queryParams'] as $key => $option):

                $this->options['query'][$key] = $actualRow[$option];

            endforeach;

        endif;

        if(isset($this->options['query'])):

            $params['query']=$this->options['query'];

        endif;

        if(isset($this->options['id'])):

            $params['id'] = $actualRow[$this->options['id']];

            $this->attr['href']  = $this->url($this->route,[
                'id'=>$params['id']
            ],$params);

        else:

            $params['id'] = $context;

            $this->attr['href']  = $this->url($this->route,[
                'id'=>$params['id']
            ], $params);

        endif;

        if(isset($this->options['context']) && $this->options['context']):

            $this->vars['context'] = $context;

        endif;

        $vars['icon'] = isset($this->options['icon'])?$this->options['icon']:'fa fa-edit';

        $this->vars['icon'] = $this->partial('buttons/icon',$vars);

        $this->vars['attr'] = $this->getDecoratorAttributes($this->attr);

        $this->getCell()->clearVar();

        return $this->partial('buttons/btn',$this->vars);
    }
}





















