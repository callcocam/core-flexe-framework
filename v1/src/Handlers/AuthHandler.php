<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 09:25
 */

namespace Flexe\Handlers;


use Carbon\Carbon;
use Flexe\Handlers\Contracts\HandlersInterface;
use Flexe\Storage\Session;

class AuthHandler implements HandlersInterface
{

    public function handle($event)
    {
        $identity = new Session();

        if($identity && $event->user):

            unset($event->user['password']);

            if(is_array($identity->get('user'))):

                $user = array_merge($identity->get('user'), $event->user);

            else:

                $user = $event->user;

            endif;

            list($y, $m, $d) = format_date($user['created_at']);

            $user['created_at'] = Carbon::createFromDate($y, $m, $d)->format("d/m/Y H:i:s");

            list($y, $m, $d, $h,$i,$s) = format_date_time($user['updated_at']);

            $user['updated_at'] = Carbon::create($y, $m, $d, $h,$i,$s)->format("d/m/Y H:i:s");

            $identity->set('user', $user);

        endif;
    }
}