<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 11:12
 */

namespace Flexe\Helper\Extras;


use Flexe\Helper\HtmlElement;

class CrumbElement extends HtmlElement
{


    private $li = [];

    public function __construct(string $tag, string $text = '', array $attributes = array(), bool $renderHtml = true)
    {
        parent::__construct($tag, $text, $attributes, $renderHtml);
    }

    public function crumb(){

        return $this->html('div')
            ->setClass('app-title ')
            ->setText(
                $this->html('div')
                    ->setText(
                        $this->html('h1')
                            ->setText($this->html('i')->setClass('fa fa-dashboard fa-lg'))->appendText("Dash")
                    )->appendText( $this->html('p')->setText("Manutenção"))
            )->appendText(
                $this->html('ul')
                    ->setClass('breadcrumb app-breadcrumb breadcrumb-holder')
                    ->setText( implode(PHP_EOL, $this->li)
                    )
            );
    }


    public function bread($content, $route = "#"){

        $this->li[] = $this->html('li')->setClass('breadcrumb-item')->setText(
            $this->html('a')->setAttributes([
                'href'=>$route
            ])->setText($content)
        );

        return $this;
    }

    public function active($content){

        $this->li[] = $this->html('li')->setClass('breadcrumb-item active')->setText($content);

        return $this;
    }

}