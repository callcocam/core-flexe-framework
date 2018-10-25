<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 20:27
 */

namespace Flexe\Table\Decorator;


interface DecoratorInterface
{

    /**
     * @param $context
     * @return mixed
     */
    public function render($context);

}