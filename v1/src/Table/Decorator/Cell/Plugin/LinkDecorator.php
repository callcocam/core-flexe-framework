<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 21:28
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class LinkDecorator extends AbstractCellDecorator
{

    protected $vars;

    protected $url;

    /**
     * LinkCell constructor.
     * @param $options
     */
    public function __construct(array $options = [])
    {
        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

        $this->options = $options;

        if(!isset($this->options['url'])):

            throw new \InvalidArgumentException('Url key in options argument required');

        endif;

        $this->url = $this->options['url'];

    }


    public function render($context)
    {

        $actualRow = $this->getActualRow();

        $this->vars['context'] = $context;

        if(isset($this->options['attr'])):

            $this->getCell()->getTable()->setAttributes($this->options['attr']);

        endif;



        if(isset($this->options['id'])):

            $this->getCell()->getTable()->setAttribute('href', sprintf($this->url, $actualRow[$this->options['id']]));

        else:

            $this->getCell()->getTable()->setAttribute('href', sprintf($this->url, $context));

        endif;

        $this->vars['attr'] = $this->getCell()->getTable()->getAttrs();

        return $this->partial('buttons/link',$this->vars);
    }
}





















