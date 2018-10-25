<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:19
 */

namespace Flexe\Table\Options;


class Option extends AbstractOptions
{

    protected $id = 'id';

    protected $title = 'Basic Table';

    protected $status = 'status';

    protected $date = 'created_at';

    protected $showStatus = [
        '1'=>"Ativo",
        '0'=>"Inativo",
    ];

    protected $showItems = [6,12,24,48,95];

    protected $showDate  = true;

    protected $showBetween  = [
        'CurrentHour'=>"Está Hora",
        'LastHour'=>"Ultima Hora",
        'CurrentDay'=>"Este Dia",
        'LastDay'=>"Ultimo Dia",
        'CurrentWeek'=>"Esta Nemana",
        'LastWeek'=>"Ultimo Nemana",
        'CurrentMonth'=>"Este Mês",
        'LastMonth'=>"Último Mês",
        'CurrentYear'=>"Este Ano",
        'CurrentYear'=>"Último Ano",
    ];

    protected $showSearch  = true;

    protected $showOder  = true;

    protected $showColumn  = true;

    protected $showActions = true;

    protected $itemPerPage = 12;

    /**
     * AbstractOptions constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;

        $this->int();
    }

    public function int()
    {
       if($this->options):

           foreach ($this->options as $name => $option):

               $this->{$name} =  $option;

            endforeach;

       endif;

    }



}















