<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 23/10/2018
 * Time: 13:13
 */

namespace Flexe\Plugins\Select2;


use Flexe\Helper\TraitHelper;

class Select2
{

    use TraitHelper;

    private $int;

    protected $data;

    public function __construct($int)
    {

        $this->int = $int;
    }


    public function load($template, $params=[]){

        if(isset($params['attr'])) {

            $params['attr'] = $this->getAttr($params['attr']);

        }

        $this->data = $this->partial($template,$params);

        return $this->data;
    }


    protected function getAttr($attrs){

        $attr = [];

        foreach ($attrs as $key => $value):

            $attr[] = sprintf('%s ="%s"', $key,$value);

        endforeach;

        return implode(" ", $attr);



    }
    public function __toString()
    {
       return $this->data;
    }
}