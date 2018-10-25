<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 09:19
 */

namespace Flexe\Table\Params;


class Params extends AbstractParam
{


    protected $search = '';

    protected $status = '0';

    protected $between = '';

    protected $number = 0;

    protected $date = '';

    protected $start = '';

    protected $end = '';

    protected $order = 'DESC';

    protected $column = 'id';

    protected $limit = 12;

    protected $offset = 0;

    protected $page = 1;


    /**
     * AbstractParam constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;

    }


    public function init()
    {
        $options = $this->getOptions();

        $this->limit = $options->itemPerPage;

        if($this->params):

            foreach ($this->params as $name => $value):

                //if(isset($this->{$name})):

                    $this->__set($name, $value);

                //endif;

            endforeach;

        endif;
    }
}