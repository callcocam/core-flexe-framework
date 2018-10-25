<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 11:12
 */

namespace Flexe\Helper\Extras;


use Flexe\Helper\HtmlElement;

class TabsElement extends HtmlElement
{

    protected $rowAppendClas;

    protected $liHtml = [];

    protected $icon = '';

    protected $active = false;

    protected $content = [];

    protected $query;

    public function __construct(string $tag, string $text = '', array $attributes = array(), bool $renderHtml = true)
    {
        parent::__construct($tag, $text, $attributes, $renderHtml);
    }

    /**
     * @param mixed $icon
     * @return TabsElement
     */
    public function setIcon($icon)
    {
        $this->icon = $this->html('i')->setClass($icon);

        return $this;
    }

    /**
     * @param string $active
     * @return TabsElement
     */
    public function setActive(string $active): TabsElement
    {
        $this->active = $active;
        return $this;
    }


    public function body($content){

        $this->content[] = $content;

        return $this;

    }
    public function row(){

        return $this->html('div')

            ->setClass('row')

            ->setText(

                $this->html('div')->setClass("col-md-12")->setText($this->card())

            )->render();
    }

    /**
     * @return HtmlElement
     */
    private function card(){

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
            'class'=>' navigation nav-link',
            'href'=>$url,
            'title'=>$content,
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

    public function addQuery($key,$query){

        $this->query[$key] = $query;

        return $this;

    }

    public function getQuery(){

        return [
            'query' =>$this->query
        ];
    }

}