<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 21:13
 */

namespace Flexe\Validate\Rules;


class MaxLength extends AbstractRules
{

    protected $message = 'must be shorter than %s characters';

    public function validate($key, $value, $ruleValue)
    {
        $this->prepare($ruleValue);

        if(strlen($value) > $this->ruleValue)
        {
            if(!empty($value))
            {
                return sprintf($this->message, $this->ruleValue);
            }
        }

        return null;
    }
}