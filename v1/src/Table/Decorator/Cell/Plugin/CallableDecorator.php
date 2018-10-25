<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 10/10/2018
 * Time: 21:30
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class CallableDecorator extends AbstractCellDecorator
{

    public function __construct(array $options = [])
    {
        if (!isset($options['callable'])) {
            throw new \Exception('Please define closure');
        }
       $this->options = $options;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function render($context)
    {
        $closure = $this->options['callable'];
        return $closure($context, $this->getCell()->getActualRow());
    }
}