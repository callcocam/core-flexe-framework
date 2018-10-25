<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 11:12
 */

namespace Flexe\Helper\Extras;


use Flexe\Helper\HtmlElement;

class CardElement extends HtmlElement
{

    protected $rowAppendClas;

    protected $icon = '';

    protected $content = [];

    public function __construct(string $tag, string $text = '', array $attributes = array(), bool $renderHtml = true)
    {
        parent::__construct($tag, $text, $attributes, $renderHtml);
    }

    /**
     * @param mixed $icon
     * @return CardElement
     */
    public function setIcon($icon)
    {
        $this->icon = $this->html('i')->setClass($icon);

        return $this;
    }


    public function body($content){

        $this->content[] = $content;

        return $this;

    }
    public function row($title = "Basic Card"){

        return $this->html('div')

            ->setClass('row')

            ->setText(

                $this->html('div')->setClass("col-md-12")->setText($this->card($title))

            )->render();
    }

    /**
     * @return HtmlElement
     */
    private function card($title){

        return $this->html('div')

            ->setClass('card')

            ->setText(

                $this->html('div')->setClass("card-header")->setText(
                    $this->html('h4')->setText($title)
                )

            )->appendText(

                $this->html('div')->setClass("card-body")

                    ->setText(implode(PHP_EOL, $this->content))

            );

    }




}