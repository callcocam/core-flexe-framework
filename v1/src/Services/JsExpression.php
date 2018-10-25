<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 05/10/2018
 * Time: 21:06
 */

namespace Flexe\Services;


class JsExpression
{

    /** @var string */
    public $expression;

    /**
     * JsExpression constructor.
     * @param $expression
     */
    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->expression;
    }

}