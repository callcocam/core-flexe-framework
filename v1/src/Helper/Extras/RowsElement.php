<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 11:12
 */

namespace Flexe\Helper\Extras;


use Flexe\Helper\HtmlElement;

class RowsElement extends HtmlElement
{

    protected $rowAppendClas;

    protected $collHtml = [];

    protected $rowHtml = [];

    public function __construct(string $tag, string $text = '', array $attributes = array(), bool $renderHtml = true)
    {
        parent::__construct($tag, $text, $attributes, $renderHtml);
    }

    public function row($class="form-group"){

        $this->rowHtml[] = $this->html('div')
            ->setClass('row')->appendClass($class)
            ->setText(implode(PHP_EOL, $this->collHtml));

        $this->collHtml = [];

        return $this;
    }


    public function columns($content, $column = 12, $class = 'col-xs-12'){

        if(is_array($content)):

            $content = implode(PHP_EOL, $content);

        endif;

        $this->collHtml[] = $this->html('div')

            ->setClass(sprintf("col-md-%s",$column))->appendClass($class)

            ->setText($content);

        return $this;
    }

    public function column($content, $column = 12, $class = 'col-xs-12'){

        if(is_array($content)):

            $content = implode(PHP_EOL, $content);

        endif;

        $this->collHtml[] = $this->html('div')

            ->setClass(sprintf("col-md-%s",$column))->appendClass($class)

            ->setText($content);

        return $this;
    }

    public function __toString()
    {
        $rowHtml = $this->rowHtml;

        $this->rowHtml = [];

        return implode(PHP_EOL, $rowHtml);
    }

}