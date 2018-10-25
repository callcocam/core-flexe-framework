<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 11:12
 */

namespace Flexe\Helper\Extras;


use Flexe\Helper\HtmlElement;

class ContentElement extends HtmlElement
{


    private $_header = 'Basic Form';

    private $_body = [];

    private $_footer = '';

    public function __construct(string $tag, string $text = '', array $attributes = array(), bool $renderHtml = true)
    {
        parent::__construct($tag, $text, $attributes, $renderHtml);
    }

    public function content(){

        $content = $this->html('section')

            ->setClass('forms')

            ->appendText(

                $this->html('div')->setClass('container-fluid')

                    ->setText( $this->html('div')->setClass('card')->setText(

                        $this->_header

                    )->appendText(

                        $this->html('div')->setClass('card-body')->setText(

                            implode(PHP_EOL, $this->_body)

                        )

                    )

                    )
            );

        if(!empty($this->_footer)):

            $content->appendText($this->_footer);

        endif;

        return $content->render();
    }

    public function header($headerText){

        $this->_header =  $this->html('div')->setClass('card-header d-flex align-items-center')->setText(

            $this->html('h4')
                ->setText(

                    $headerText

                )
        );

        return $this;
    }

    public function body($content){

        $this->_body[] = $content;

        return $this;
    }


    public function footer($footer){

        $this->_footer = $this->html('div')->setClass('card-footer')->setText(

            $footer

        );

        return $this;
    }

}