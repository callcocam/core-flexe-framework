<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 05/09/2018
 * Time: 11:23
 */

namespace Flexe\Table;


class Render extends AbstractElement
{

    protected $options = [];

    private $param = [];

    private $_theme = '';

    public function __construct(AbstractTable $table)
    {
        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

        $this->setTable($table);

        $this->setRouter($table->getRouter());

        $this->options = $this->getTable()->getOptions();

        $this->param = $this->getTable()->getParams();

        $this->param->init();

        $this->_theme = $this->getTable()->getTheme();
    }

    /**
     * Rendering head
     *
     * @return string
     */
    public function renderHead()
    {
        $headers = $this->getTable()->getHeaders();

        $render = [];

        foreach ($headers as $name => $options) {

            $render[]= $this->getTable()->getHeader($name)->render($options);

        }
        return $this->load("thead",[

            'content'=>implode("",$render)

        ]);
    }

    /**
     * @return array
     */
    public function html($template='template'){

        $this->setVariable('paramswrap',$this->paramsWrap());

        $filters = $this->load("filters",
            [
                'state' =>$this->state(),
                //'start-end' =>$this->start_and_end(),
                'search' =>$this->search(),
                'order' =>$this->order(),
                'column' =>$this->column(),
                'between' =>$this->between(),
                'number' =>$this->number(),
                'action' => $this->url(sprintf('%s.%s', $this->param->route, $this->param->controller)),
            ]);

        $this->setVariable('select',$this->getTable()->getSource()->getSelect());

        $data = $this->load($template,
            [
                'actions' => $this->actions(),
                'title' => $this->options->title,
                'head' => $this->renderHead(),
                'content' => $this->getTable()->getRow()->renderRow(),
                'attr' =>$this->getTable()->getAttributes(),
                'footer' =>$this->getPaginator()->toHtml(),
                'paramswrap' =>$this->variables['paramswrap'],
                'filter' =>$filters,
            ]);

        $this->setVariable('head',$this->renderHead());

        $this->params($data);

        return $this->variables;
    }

    public function json(){

        $this->paramsWrap();

        $data = $this->getTable()->getRow()->renderRow('array_assc');

        $this->params($data);

        return $this->variables;
    }

    public function custom($template){

        $this->paramsWrap();

        $data = $this->load($template,
            [
                'actions' => $this->actions(),
                'title' => $this->options->title,
                'head' => $this->renderHead(),
                'content' => $this->getTable()->getRow()->renderRow(),
                'attr' =>$this->getTable()->getAttributes()
            ]);

        $this->params($data);

        return $this->variables;

    }

    private function params($data){

        $this->setVariable('options',$this->options);

        $this->setVariable('params',$this->param);

        $this->setVariable('paginator',$this->getPaginator());

        $this->setVariable('rows',$data);

    }

    private function paramsWrap(){

        $this->setVariable('title',$this->options->title);

        $this->setVariable('TableStatus',$this->param->status);

        $this->setVariable('TableStartDate',$this->param->start);

        $this->setVariable('TableEndDate',$this->param->end);

        $this->setVariable('TableColumn',$this->param->column);

        $this->setVariable('TableOrder',$this->param->order);

        $this->setVariable('TableItemPerPage',$this->param->limit);

        $this->setVariable('TablePage',$this->param->page);

        $this->setVariable('TableBetween',$this->param->between);

        $this->setVariable('TableNumber',$this->param->number);

        $this->setVariable('TableOffSet',($this->param->page * $this->param->limit) - $this->param->limit);

        $this->setVariable('TableQuickSearch',$this->param->search);

        $this->setVariable('action',$this->url(sprintf('%s.%s', $this->param->route, $this->param->controller)));
        
        $this->param->offset = ($this->param->page * $this->param->limit) - $this->param->limit;

        return $this->load("params-wrap",$this->variables);
    }

    private function actions(){


        if ($this->options->showActions):

            $showActions = $this->options->showActions;

            $attribute = [];

            $label = '';

            if(isset($showActions['attribute'])):

                $attribute = $showActions['attribute'];

            endif;

            if(!isset($attribute['class'])):

                $attribute['class'] = 'navigation btn-ajax btn btn-success';

            else:

                $attribute['class'] = sprintf('navigation btn-ajax %s', $attribute['class']);

            endif;

            if(!isset($attribute['title'])):

                $attribute['title'] = $this->options->title;

            endif;

            $params  = $this->param->getParams();

            if(isset($showActions['route'])):

                $attribute['href'] = $this->url($showActions['route'],[],[
                    'query'=>$params
                ]);

            endif;

            if(isset($showActions['label'])):

                $label = $showActions['label'];

            endif;

            return $this->load("buttons/add",[

                'attr'=>$this->getRenderAttr($attribute),
                'label'=>$label,

            ]);

        endif;

        return "";

    }

    private function state(){


        $limit = $this->param->limit;

        $html[] ='<option>--Selecione--</option>';

        $selected ='';

        if ($this->options->showItems):

            foreach ($this->options->showItems as $item):

                if($item == $limit):

                    $selected =' selected';

                endif;

                $html[] =sprintf('<option value="%s" %s>%s</option>',$item,$selected,$item);

                $selected ='';

            endforeach;

            return $this->load("filter/state",[

                'content'=>implode("",$html)

            ]);

        endif;

        return "";

    }

    private function start_and_end(){

        if ($this->options->showDate):

            return $this->partial("filter/start-end",[

                'content'=>sprintf("%s - %s",$this->param->start,$this->param->end)

            ]);

        endif;

        return "";

    }

    private function number(){

        if ($this->options->showDate):

            return $this->load("filter/number",[

                'content'=>$this->param->number

            ]);

        endif;

        return "";

    }

    private function between(){

        if ($this->options->showBetween):

            $showBetween =$this->options->showBetween;

            $between = $this->param->between;

            $html[] ='<option>--Selecione--</option>';

            $selected ='';

            if ($showBetween):

                foreach ($showBetween as $key => $item):

                        if($key == $between):

                            $selected =' selected';

                        endif;

                        $html[] =sprintf('<option value="%s" %s>%s</option>',$key,$selected,$item);

                    $selected ='';

                endforeach;
            endif;

            return $this->load("filter/between", [

                'content'=>implode("",$html)

            ]);

        endif;

        return "";

    }


    private function column(){

        if ($this->options->showColumn):

            $headers =$this->getTable()->getHeaders();

            $column = $this->param->column;

            $html[] ='<option>--Selecione--</option>';

            $selected ='';

            if ($headers):

                foreach ($headers as $key => $item):


                    if(isset($item['name'])):

                        if($item['name'] == $column):

                            $selected =' selected';

                        endif;

                        $html[] =sprintf('<option value="%s" %s>%s</option>',$item['name'],$selected,$item['title']);

                    endif;

                    $selected ='';

                endforeach;
            endif;

            return $this->load("filter/column",[

                'content'=>implode("",$html)

            ]);

        endif;

        return "";

    }
    private function order(){

        if ($this->options->showOder):

            $order = $this->param->order;

            $selected ='';
            if("ASC" == strtoupper($order)):

                $selected =' selected';

            endif;

            $html[] =sprintf('<option value="ASC" %s>ASC</option>',$selected);

            $selected ='';

            if("DESC" == strtoupper($order)):

                $selected =' selected';

            endif;

            $html[] =sprintf('<option value="DESC" %s>DESC</option>',$selected);

            return $this->load("filter/order",[

                'content'=>implode("",$html)

            ]);

        endif;

        return "";
    }
    private function search(){

        if ($this->options->showSearch):

            return $this->load("filter/search",[

                'content'=>$this->param->search

            ]);

        endif;

        return "";

    }

    private function getPaginator(){

        return new Paginator($this->getTable()->getSource()->getTotal(),$this->param->limit,$this->param->page, 'pg');

    }

    private function getRenderAttr($attrs = []){

        $attributes = [];

        if($attrs):

            foreach ($attrs as $key => $attr):

                $attributes[] = sprintf(' %s="%s"', $key, $attr);

            endforeach;

        endif;

        return implode(" ", $attributes);
    }

    private function load($view,$data=[]){

        return $this->partial(sprintf("%s/%s", $this->_theme,$view),$data);

    }
}