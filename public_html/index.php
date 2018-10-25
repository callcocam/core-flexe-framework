<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 09:23
 */

include __DIR__ . "/../vendor/autoload.php";


if(!defined("__APP_SISTEMA__")):

    define("__APP_SISTEMA__","sistema");

endif;


if(!defined("__APP_CONFIG__")):

    define("__APP_CONFIG__","/");

endif;


if(!defined("__APP_REDIRECT__")):

    define("__APP_REDIRECT__","");

endif;


if(!defined("__APP_THEME__")):

    define("__APP_THEME__","home");

endif;

if(!defined("__THEME__")):

    define("__THEME__","vali/");

endif;

\Flexe\Storage\StartSession::sec_session_start();


$settings['settings'] = (new \Flexe\Config\Read\ReadConfig())->getConfig();

$app = new \Flexe\Application($settings);

$app->run();