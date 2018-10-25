<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 23:45
 */

namespace Flexe\Table\Decorator\Condition\Plugin;


use Flexe\Table\Decorator\Condition\AbstractCondition;

class NotEq extends AbstractCondition
{

    protected $column;

    protected $values;

    public function __construct(array $options = [])
    {
        $this->options = $options;

    }

    public function isValid()
    {

        $this->column = $this->options['column'];

        $this->values = is_array($this->options['values'])? $this->options['values'] : [ $this->options['values'] ];

        $row = $this->getActualRow();

        foreach ($this->values as $value):

            if($row[$this->column] == $value):

                return false;

            endif;

        endforeach;

        return true;
    }


}