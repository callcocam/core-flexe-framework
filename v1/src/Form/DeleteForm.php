<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 06/09/2018
 * Time: 18:57
 */

namespace Flexe\Form;


class DeleteForm extends Form
{
    public function __construct(string $name = "AjaxForm", $settings = null)
    {
        parent::__construct($name, $settings);

        $this->setAttributes([
            'class'=>'text-left form-validate',
            'id'=>$name,
            'name'=>$name,
            'action'=>'admin',
            'method'=>'post',
            "enctype"=>"multipart/form-data",
        ]);

        $this->add($this->addHidden('name'));

        $this->add($this->setAttributesSubmit([
            'class'=>'btn btn-danger',
            'content'=>'Deseja Realmente Excluir',
        ])->addSubmit());
    }
}