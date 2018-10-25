<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/09/2018
 * Time: 12:28
 */

namespace Flexe\Helper;


use Flexe\Storage\Session;

class Alert extends AbstractHelper
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

            $alert[] ='<div class="alert alert-%s alert-dismissible" role="alert">';
            $alert[] ='        <strong>%s!</strong> %s.';
            $alert[] ='            <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $alert[] ='            <span aria-hidden="true">&times;</span>';
            $alert[] ='        </button>';
            $alert[] ='    </div>';

            $this->alert[] =sprintf(implode(PHP_EOL, $alert),$type,ucfirst($type),$this->session->get('message'));


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