<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 11:12
 */

namespace Flexe\Helper\Extras;


use Flexe\Helper\HtmlElement;

class TableElement extends HtmlElement
{

    protected $rowAppendClas;

    protected $tr;

    protected $th;

    protected $td;


    protected $content = [];

    public function __construct(string $tag, string $text = '', array $attributes = array(), bool $renderHtml = true)
    {
        parent::__construct($tag, $text, $attributes, $renderHtml);
    }



    public function body($content){

        $this->content[] = $content;

        return $this;

    }
    public function row(){

        $this->tr = $this->html('tr')->setText("");

        if($this->td):

            foreach ($this->td as $value):

                $this->tr->appendText($value);

            endforeach;

        endif;

        return $this;
    }

    /**
     * @return HtmlElement
     */
    private function table(){


        if($this->th):

            foreach ($this->th as $value):

                $th[] = $this->setTh($value);

            endforeach;

        endif;

        if($this->content):

            foreach ($this->content as $value):

                foreach ($this->th as $key => $title):

                    $th[] = $this->setTd($value[$key]);

                endforeach;

            endforeach;

        endif;
        return $this->html('div')

            ->setClass('card')

            ->setText(

                $this->html('div')->setClass("card-header")->setText($this->nav())

            )->appendText(

                $this->html('div')->setClass("card-body")->setId('tab-content')->setText(implode(PHP_EOL, $this->content))

            );

    }

    private function nav(){

        return $this->html('ul')

            ->setClass('nav nav-tabs card-header-tabs')->setId("tab-elemet")

            ->setText(implode(PHP_EOL, $this->liHtml));

        return $this;

    }

    public function item($content, $url="#"){


        $li = $this->html('li')->setClass('nav-item');

        $a = $this->html('a')->setAttributes([
            'class'=>' navigate nav-link',
            'href'=>$url
        ]);
        if($this->icon):

            $a->setText($this->icon)->appendText($content);

        else:

            $a->setText($content);

        endif;

        if($this->active):

            $a->appendClass('active');

        endif;

        $this->active = false;

        $this->liHtml[] = $li->setText($a);

        return $this;
    }

}