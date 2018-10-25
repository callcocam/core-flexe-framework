<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 25/08/2018
 * Time: 11:24
 */

namespace Flexe\Helper;

use Flexe\Form\Elements\AbstractElement;
use Flexe\Form\Form as F;
class Form
{

    protected $form;
    protected $element;

    public function openTag(F $form,$args=[], $params=[]){

        $this->form = $form;

        $attributes = [];

        $params['query'] = $params;

       $form->setAttribute('action', $form->getAction(array_merge($args,$params)));

        if($form->getAttributes()):

            foreach ($this->form->getAttributes() as $key => $attribute):

                $attributes[] = sprintf(' %s="%s"' , $key, $attribute);

            endforeach;

        endif;

        $attribute = implode(' ', $attributes);

        return "<form {$attribute}>";

    }

    public function formRow(AbstractElement $element){

        $this->element = $element;

        return $this->element;
    }

    public function closeTag(){

        return "</form>";
    }
}