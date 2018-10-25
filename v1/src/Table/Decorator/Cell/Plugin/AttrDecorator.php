<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 05/09/2018
 * Time: 13:23
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class AttrDecorator extends AbstractCellDecorator
{

    protected $attr;

    public function __construct(array $options = [])
    {

        $this->setAttr($options);
    }

    public function render($context)
    {
        if (count($this->attr) > 0) {

            foreach ($this->attr as $name => $value) {

                $this->getCell()->addAttr($name, $value);

            }

        }

        return $context;
    }

    public function getAttr()
    {
        return $this->attr;
    }

    public function setAttr($attr)
    {
        $this->attr = $attr;
    }
}