<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 17:06
 */

namespace Flexe\Validate\Rules;


class Required extends AbstractRules
{

    protected $message = 'This %s field is required';

    public function validate($key, $value, $ruleValue)
    {

        $this->prepare($ruleValue);

        if(empty($value) && $this->ruleValue == true):

            return sprintf($this->message, $key);

        endif;

        return null;

    }
}