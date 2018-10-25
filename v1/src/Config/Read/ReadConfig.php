<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 09:42
 */

namespace Flexe\Config\Read;


class ReadConfig
{

    protected $config = [];

    /**
     * ReadConfig constructor.
     */
    public function __construct()
    {
        $data = [];

        $dir = dirname(__DIR__, 4);

        $appConfigGlobal  = include sprintf("%s/%sconfig/settings/global.php", $dir, __APP_PROJECT__);
        $appConfigFileLocal  = sprintf("%s/%sconfig/settings/local.php", $dir, __APP_PROJECT__);

        $data = $appConfigGlobal;

        if(file_exists($appConfigFileLocal)):

            $appConfigLocal = include $appConfigFileLocal;

            $data = array_merge($appConfigGlobal, $appConfigLocal);

        endif;

        $paths = [];
        if(isset($data['modules'])):
            $modules = array_unique($data['modules']);

            if($modules):

                foreach ($modules as $module):

                    if(sprintf("%s/%ssrc/%s/config", $dir, __APP_PROJECT__, $module)):

                        $dir_iterator = new \RecursiveDirectoryIterator(sprintf("%s/%ssrc/%s/config", $dir, __APP_PROJECT__, $module));

                        $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);

                        foreach ($iterator as $file):

                            if($file->isFile()):

                                $paths[$module] = include str_replace("/", DIRECTORY_SEPARATOR,
                                    sprintf("%s/%ssrc/%s/config/%s", $dir, __APP_PROJECT__, $module, $file->getFileName()));

                            endif;

                        endforeach;

                    endif;

                endforeach;

                $data['modules'] = $paths;
            endif;
        endif;
        $this->config = $data;
    }

    public function getConfig(){

        return $this->config;
    }


    public function getLang($lang){
        $dir = dirname(__DIR__, 4);
        return  $appConfigGlobal  = include sprintf("%s/%sconfig/lang/%s.php",$dir, __APP_PROJECT__, $lang);
    }
}