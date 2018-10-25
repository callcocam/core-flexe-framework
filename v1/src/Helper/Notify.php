<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/09/2018
 * Time: 12:28
 */

namespace Flexe\Helper;


use Flexe\Services\JsonEncoder;
use Flexe\Storage\Session;

class Notify extends AbstractHelper
{

    protected $alert= [];

    public function __construct()
    {

        $this->session = new Session();

        $type = "info";//'info', 'success', 'warning', 'danger', 'rose', 'primary'

        $align = "right";//left, center ,right

        $from = "top";//top, bottom

        if($this->session->exists('type')):

            $type = $this->session->get('type');

        endif;

        if($this->session->exists('align')):

            $align = $this->session->get('align');

        endif;

        if($this->session->exists('from')):

            $from = $this->session->get('from');

        endif;

        if($this->session->exists('message')):

            $options[] =[
                'title'=> ucfirst($type),
                'icon' => "notifications",
                'message'=> $this->session->get('message')

            ];
            $options[] = [
                'type'=> $type,
                'timer' => 3000,
                'placement' => [
                    'from' => $from,
                    'align' => $align
                ]
            ];

            $this->alert[] ='<script>';

            $this->alert[] =sprintf("$.notify(%s,%s)", JsonEncoder::encode($options[0]),JsonEncoder::encode($options[1]));

            $this->alert[] ='</script>';

        endif;

        $this->session->clear('message');

        $this->session->clear('type');

        $this->session->clear('align');

        $this->session->clear('from');

    }

    public function __toString()
    {
        return implode("", $this->alert);
    }

}