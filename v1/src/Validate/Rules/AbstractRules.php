<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 17:04
 */

namespace Flexe\Validate\Rules;


use Flexe\Validate\Rules\Contracts\RulesInterface;

abstract class AbstractRules implements RulesInterface
{

    protected $ruleValue;

    protected $message = 'This %s field is invalid';


    protected function prepare($ruleValue){

        if(is_array($ruleValue)):

            if(isset($ruleValue['value'])):

                $this->ruleValue = $ruleValue['value'];

            endif;
            if(isset($ruleValue['message'])):

                $this->message = $ruleValue['message'];

            endif;

        else:

            $this->ruleValue = $ruleValue;

        endif;

    }



}