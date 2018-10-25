<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 16:09
 */

namespace Flexe\Validate;


use Flexe\Validate\Rules\MaxLength;
use Flexe\Validate\Rules\Required;
use Flexe\Validate\Rules\ValidEmail;

class Validate extends AbstractValidate
{

    /**
     * @param string $name
     * @param array $filters
     */
    protected function add(string $name, array $filters){


        $this->setValidation($name, $filters);

    }

    /**
     * @param $Rule
     * @return mixed
     * @throws \Exception
     */
    public function RulesExist($Rule)
    {

        if(class_exists($Rule)):

            return $Rule;

        endif;

        $this->pluginsRules =[

            'required' => Required::class,

            'validEmail' => ValidEmail::class,

            'maxLength' => MaxLength::class
        ];

        if(array_key_exists($Rule, $this->pluginsRules)):

            return $this->pluginsRules[$Rule];

        endif;

        throw new \Exception("Class rule {$Rule} not found");
    }
}