<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 05/09/2018
 * Time: 19:00
 */

namespace Flexe\Table\Sources;


class Eloquent extends AbstractSource
{

    /**
     * AbstractSource constructor.
     * @param $source
     * @param $table
     */
    public function __construct($source, $table)
    {
        parent::__construct($source, $table);
    }

    protected function order()
    {
        // TODO: Implement order() method.
    }

    protected function quickSearch()
    {
        // TODO: Implement quickSearch() method.
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }
}