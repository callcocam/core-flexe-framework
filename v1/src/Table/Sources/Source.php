<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:19
 */

namespace Flexe\Table\Sources;


use Carbon\Carbon;

class Source extends AbstractSource
{
    protected $data;
    protected $total = 0;

    /**
     * AbstractSource constructor.
     * @param $source
     * @param $table
     */
    public function __construct($source, $table)
    {
        $this->source = $source;

        $this->table = $table;

        $this->select = $this->getSource()->from();

    }

    private function count(){

        $this->total = $this->select->count();
    }



    protected function order()
    {

        $column = $this->getParams()->column;

        $order = $this->getParams()->order;

        if(!$column):

            $this->select->orderBy(sprintf(" %s.id %s", $this->select->getFromAlias(), $order));

        endif;

        $this->select->orderBy(sprintf(" %s.%s %s", $this->select->getFromAlias(), $column, $order));

    }

    protected function quickSearch()
    {


        $this->field_date = $this->table->getOptions()->date;

        $alias = $this->select->getFromAlias();

        if (!empty(__APP_SISTEMA__)) {
            if (defined('COMPANYS_ID')) {
                $this->select->where([
                    sprintf(" %s.company_id", $alias)=>COMPANYS_ID
                ]);
            }
        }
       if($this->getParams()->status):

           $this->select->where([

               sprintf(" %s.%s", $alias, $this->table->getOptions()->status) =>$this->getParams()->status

           ]);

       endif;


        $start_date = $this->getParams()->start;

        $end_date = $this->getParams()->end;


//        if($start_date && $end_date):
//
//            /**
//             * Seleção entre datas
//             */
//
//            list($d, $m, $y) = $this->format_date($start_date);
//
//            $start_date = Carbon::create($y,$m,$d,0,0,1,\DateTimeZone::AMERICA);
//
//            list($d, $m, $y) =  list($y, $m, $d) = $this->format_date($end_date);;
//
//            $end_date = Carbon::create($y,$m,$d,23,59,59);
//
//            $this->select->where([
//
//                sprintf(" %s.%s >= ? ", $alias, $this->field_date) => $start_date->format("Y-m-d 00:00:01")
//
//            ])->where([
//
//                sprintf(" %s.%s <= ? ", $alias, $this->field_date) => $end_date->format( "Y-m-d 23:59:59")
//
//            ]);
//
//        endif;

        $between = $this->getParams()->between;

        $number = $this->getParams()->number;

        if($between):

            /**
             * Seleção entre datas
             */
            if(method_exists($this, $between)):

                $this->$between($this->select, $number);

            endif;

        endif;


        $anyKeyword = $this->getParams()->search;

            $headers = $this->table->getHeaders();

            if($headers):

                $fields = [];

                $arrayAlias = [];

                $Searchs = [];


                foreach ($headers as $values):

                    if (isset($values['name'])):

                        if (isset($values['alias'])):

                            if($alias == $values['alias']):

                                $fields[] = sprintf("%s.%s As %s_%s ", $alias, $values['name'], $alias, $values['name']);

                            else:

                                $arrayAlias[$values['alias']] = sprintf("%s.%s As %s_%s ", $values['alias'], $values['name'], $values['alias'], $values['name']);

                            endif;

                            $Searchs[] = sprintf("%s.%s", $values['alias'], $values['name']);
                        else:

                            $fields[] = sprintf("%s.%s As %s_%s ", $alias, $values['name'], $alias, $values['name']);

                        endif;

                    endif;


                endforeach;

                if(count($arrayAlias) > 1):

                    foreach ($arrayAlias as $join => $v):

                        if($join != $alias):

                            $this->select->leftJoin($join);

                        endif;

                    endforeach;

                endif;

                $columns  = array_merge(array_values($arrayAlias), array_values($fields));

                //$columns = substr(implode("," , array_values($columns)), 0);
                $columns = implode("," , array_values($columns));

                $Searchs = implode("," , array_values($Searchs));

                $this->select->select(null)->select($columns);

                if($anyKeyword):

                    $this->select->where(" CONCAT_WS(' ', {$Searchs} ) LIKE '%{$anyKeyword}%' ");

                    $this->select->disableSmartJoin();

                endif;

       endif;

        $this->count();

        $this->select->offset(($this->getParams()->page * $this->getParams()->limit) - $this->getParams()->limit);

        $this->select->limit($this->getParams()->limit);

    }

    /**
     * @return int
     */
    public function getTotal(){

        return $this->total;

    }
    public function getData()
    {
        $this->initQuery();
        //dd($this->select->getParameters());
        //dd($this->select->getQuery());
        $this->data = $this->select->findAll();
        return $this->data;
    }

    public function format_date($Date)
    {
        $Format = str_replace(['-','/'],[' ',' '], $Date);
        $Result = explode(' ', $Format);
        return $Result;
    }



}