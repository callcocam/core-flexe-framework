<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 17:02
 */

namespace Flexe\Validate\Rules\Contracts;


interface RulesInterface
{

    public function validate($key, $value, $ruleValue);

}