<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 21:28
 */

namespace Flexe\Table\Decorator\Cell\Plugin;


use Carbon\Carbon;
use Flexe\Table\Decorator\Cell\AbstractCellDecorator;

class DateDecorator extends AbstractCellDecorator
{

    protected $vars;

    protected $url;

    /**
     * LinkCell constructor.
     * @param $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }


    public function render($context)
    {

        if(isset($this->options['time']) && $this->options['time']):

            $format = "d/m/Y H:i:s";

            if(isset($this->options['format'])):

                $format = $this->options['format'];

            endif;

            $date = str_replace(['/','-', ":"], [' ', ' ', ' '], $context);

            $dateArray = explode(" ", $date);
            $y = null;
            $m = null;
            $d = null;
            $h = null;
            $i = null;
            $s = null;
            if(isset($dateArray[3])):

                list($y, $m, $d, $h, $i, $s) = $dateArray;

            else:

                list($y, $m, $d) = $dateArray;

            endif;

            return Carbon::create($y, $m, $d, $h, $i, $s)->format($format);

        else:

            $format = "d/m/Y";

            if(isset($this->options['format'])):

                $format = $this->options['format'];

            endif;

            $date = str_replace(['/','-'], [' ', ' '], $context);

            $dateArray = explode(" ", $date);

            list($y, $m, $d) = $dateArray;

            return Carbon::create($y, $m, $d)->format($format);

        endif;
    }
}





















