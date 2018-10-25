<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/09/2018
 * Time: 22:30
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class StatusDecorator extends AbstractCellDecorator
{

    public function __construct(array $options = [])
    {
        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

        $this->options = $options;

    }

    /**
     * @param $context
     * @return mixed
     */
    public function render($context)
    {
        $actualRow = $this->getActualRow();

        $template = "/buttons/status";

        $attr['checked'] = $context?'checked':'';

        $attr['data-href']  = '';

        if(isset($this->options['route']) && isset($this->options['id'])):

           $attr['data-href']  = $this->url($this->options['route'],[

                'id'=>$actualRow[$this->options['id']]

            ]);

        endif;

        return $this->partial($template, $attr);
    }
}