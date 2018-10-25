<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 16:09
 */

namespace Flexe\Validate;


use Flexe\Validate\Rules\Contracts\RulesInterface;

abstract class AbstractValidate
{
    /**
     * Rule             value               Description
     * -----------      ---------           -----------
     * name             string              O nome do campo
     * required         boolean             Set if the field is required
     * validEmail       boolean             Validates an email address
     * validURL         boolean             Validates an URL
     * match            Fieldname to match  The fields value needs to match the value of the field given to match
     * numeric          boolean             Checks if the value contains only numeric characters
     * alpha            boolean             Checks if the value contains only alphabetical characters
     * aplhaNumeric     boolean             Checks if the value contains only alpha-numeric characters
     * minLength        int                 Checks if the value has less characters than the minLength
     * maxLength        int                 Checks if the value has more characters than the maxLength
     * exactLength      int                 Checks if the value is the exact length of the exactLength
     * lessThan         int                 Checks if the value is less than lessThan
     * greaterThan:     int                 Checks if the value is greater than greaterThan
     */

    protected $pluginsRules = [];

    protected $post;

    protected $validationRules = [];

    protected $validationErrors;

    protected $validationTable;

    abstract public function RulesExist($Rule);

    /**
     * @param $Name
     * @param $validationRules
     */
    public function setValidation($Name, $validationRules)
    {
        $this->validationRules[$Name] = $validationRules;
    }

    public function validateField($key, $value){

        $value = trim($value);

        if(array_key_exists($key, $this->validationRules)):

            foreach ($this->validationRules[$key] as $rule => $ruleValue):



                $rule = $this->RulesExist($rule);


                /**
                 * @var  $class RulesInterface
                 */

                $class = new $rule;

                if(!isset($this->validationErrors[$key]))
                {
                    $result = $class->validate($key, $value, $ruleValue);

                    if($result):

                        $this->validationErrors[$key] = $result;

                    endif;
                }

            endforeach;

        endif;

        if(empty($this->validationErrors)):

            return true;

        endif;

        return false;

    }


    public function validateFields($post){

        $this->post = $post;

        foreach ($this->post as $key => $value):

            $value = trim($value);

            if(array_key_exists($key, $this->validationRules)):

                foreach ($this->validationRules[$key] as $rule => $ruleValue):


                    $rule = $this->RulesExist($rule);

                    /**
                     * @var  $class RulesInterface
                     */

                    $class = new $rule;

                    if(!isset($this->validationErrors[$key]))
                    {
                        $result = $class->validate($key, $value, $ruleValue);

                        if($result):

                            $this->validationErrors[$key] = $result;

                        endif;
                    }


                endforeach;

            endif;

        endforeach;

        if(empty($this->validationErrors)):

            return true;

        endif;

        return false;

    }



    /**
     * @return mixed
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }


}