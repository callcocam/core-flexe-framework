<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/09/2018
 * Time: 00:33
 */

namespace Flexe\Validate\Rules;


class ValidEmail extends AbstractRules
{

    protected $message = 'Please fill in a valid email addresss';

    public function validate($key, $value, $ruleValue)
    {
        $this->prepare($ruleValue);

        if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value) && $this->ruleValue == TRUE)
        {
           return $this->message;
        }

        return null;
    }
}