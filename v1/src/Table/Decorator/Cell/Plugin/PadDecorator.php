<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/09/2018
 * Time: 22:30
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class PadDecorator extends AbstractCellDecorator
{

    protected $pad_length   = 5;
    protected $pad_string   = '0';
    protected $pad_type;

    public function __construct(array $options = [])
    {
        $this->options = $options;

        $this->pad_length   = isset($this->options['length'])   ?  $this->options['length']  :       $this->pad_length;
        $this->pad_string   = isset($this->options['string'])   ?  $this->options['string']  :       $this->pad_string;
        $this->pad_type     = isset($this->options['type'])     ?  $this->options['type']    :       STR_PAD_LEFT;


    }

    /**
     * @param $context
     * @return mixed
     */
    public function render($context)
    {
         return str_pad($context, $this->pad_length, $this->pad_string, $this->pad_type);
    }
}