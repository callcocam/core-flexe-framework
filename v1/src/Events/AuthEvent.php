<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 09:24
 */

namespace Flexe\Events;


class AuthEvent extends Event
{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}