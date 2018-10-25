<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 18:14
 */

namespace Flexe\Table;


use Flexe\Table\Decorator\DecoratorFactory;

class Cell extends AbstractElement
{
    /**
     * @var Header
     */
    protected $header;

    /**
     * Cell constructor.
     * @param Header $header
     */
    public function __construct(Header $header)
    {
        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

        $this->header = $header;

    }

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @param Header $header
     * @return Cell
     */
    public function setHeader(Header $header): Cell
    {
        $this->header = $header;
        return $this;
    }

    public function addDecorator($name, $options = []){

        $decorator = DecoratorFactory::factoryCell($name, $options);

        $decorator->setCell($this);

        $decorator->setRouter($this->getTable()->getRouter());

        $this->attachDecorators($decorator);

        return $decorator;
    }


    public function getActualRow(){

        return $this->table->getRow()->getActualRow();

    }

    public function render($type = 'html'){

        $value = '';
        $index = $this->getHeader()->index;
        $options = $this->getHeader()->options;



        $row = $this->getActualRow();

        $template = 'cell';




        if(isset($options[$index])):

            if(isset($options[$index]['template'])):

                $template = $options[$index]['template'];

            endif;
            if (isset($options[$index]['visible'])):

                if(!$options[$index]['visible']):

                    return '';
                endif;

            endif;
        endif;

        if(is_array($row)):

            if(isset($row[$index])):

                $value = $row[$index];

            endif;


        endif;


        foreach ($this->decorators as $decorator):

            if($decorator->validConditions()):

                $value = $decorator->render($value);

            endif;

        endforeach;

        if($type == 'html'):
            $attr = $this->getAttrs();
            $this->clearVar();
            return $this->partial(sprintf("%s%s", $this->getTable()->getTheme(),$template), [
                'tag'=>'td',
                'content'=>$value,
                'attr'=>$attr,

            ]);

        endif;

        return $value;

    }
}














