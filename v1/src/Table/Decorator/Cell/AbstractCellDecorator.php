<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 20:12
 */

namespace Flexe\Table\Decorator\Cell;

use Flexe\Table\Decorator\AbstractDecorator;
use Flexe\Table\Decorator\DataAccessInterface;
use Flexe\Table\Decorator\DecoratorInterface;

abstract class AbstractCellDecorator extends AbstractDecorator implements DataAccessInterface, DecoratorInterface
{


    protected $cell;

    protected $options;

    abstract public function __construct(array $options = []);

    /**
     * @return mixed
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     * @param mixed $cell
     * @return AbstractCellDecorator
     */
    public function setCell($cell)
    {
        $this->cell = $cell;
        return $this;
    }

    public function getActualRow(){

        return $this->getCell()->getActualRow();

    }

    /**
     * Get attributes as a string
     *
     * @return null|string
     */
    public function getDecoratorAttributes($attributes)
    {
        $ret = array();

        if (count($attributes)) {
            foreach ($attributes as $name => $value) {
                $ret[] = sprintf( '%s="%s"',$name, $value);
            }
        }
        return ' ' . implode(' ', $ret);
    }
}