<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 08:56
 */

namespace Flexe\Events;


use Flexe\Handlers\Contracts\HandlersInterface;

class Event
{


    protected $handlers = [];


    public function attach($handlers){

        if(is_array($handlers)):

            foreach ($handlers as $handler):

                if($handler instanceof HandlersInterface):

                    continue;

                endif;

                $this->handlers[] = $handler;

            endforeach;

            return ;

        endif;
        if(!$handlers instanceof HandlersInterface):

            return;

        endif;

        $this->handlers[] = $handlers;
    }

    public function dispatch(){

        foreach ($this->handlers as $handler):

            $handler->handle($this);

        endforeach;
    }
}