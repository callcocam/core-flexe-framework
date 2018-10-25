<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/09/2018
 * Time: 22:30
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Db\Extras\Utilities;
use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class FloatDecorator extends AbstractCellDecorator
{

    public function __construct(array $options = [])
    {
        $this->options = $options;

    }

    /**
     * @param $context
     * @return mixed
     */
    public function render($context)
    {
         return Utilities::form_read($context);
    }
}