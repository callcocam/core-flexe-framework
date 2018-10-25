<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/09/2018
 * Time: 12:20
 */

namespace Flexe\Plugins\Notify;


use Flexe\Storage\Session;

class Notify
{

    protected $session;

    public function __construct()
    {

        $this->session = new Session();

    }

    /**
     * Flash an alert.
     *
     * @param string $message
     * @param string $type
     * @param string $from
     * @param string $align
     * @return Notify
     */
    public function flash(string $message, string $type = 'info', $from='top', $align='right')
    {
        $this->session->flash($message,'message');
        //top, bottom
        $this->session->flash($from,'from');
        //left, center ,right
        $this->session->flash($align,'align');

        $this->session->flash($type,'type');

        return $this;
    }

    /**
     * Flash a danger alert.
     *
     * @param string $message
     *
     * @return Notify
     */
    public function danger(string $message)
    {
        return $this->flash($message, 'danger');
    }

    /**
     * Flash an info alert.
     *
     * @param string $message
     *
     * @return Notify
     */
    public function info(string $message)
    {
        return $this->flash($message, 'info');
    }

    /**
     * Flash a success alert.
     *
     * @param string $message
     *
     * @return Notify
     */
    public function success(string $message)
    {
        return $this->flash($message, 'success');
    }

    /**
     * Flash a warning alert.
     *
     * @param string $message
     *
     * @return Notify
     */
    public function warning(string $message)
    {
        return $this->flash($message, 'warning');
    }

}