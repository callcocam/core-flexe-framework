<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 01:20
 */

namespace Flexe\Storage;


class StartSession
{

    /**
     * Security Session Start.
     *
     * @param bool $regenerate Regerar sessão após start
     */
    public static function sec_session_start(bool $regenerate = false)
    {
        ob_start();

        session_start();

    }

}