<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 14/09/2018
 * Time: 21:57
 */

namespace Flexe\Views\Extras;


class Helper
{


    protected $paths = [];
    /**
     * Helper constructor.
     * @param string $module
     */
    public function __construct($module = "/Extras")
    {

        $dir = dirname(__DIR__, 2);

        $isDir = sprintf("%s/v1/src/Helper%s", $dir, $module);

        $this->paths = [];

        if(is_dir($isDir)):

            $dir_iterator = new \RecursiveDirectoryIterator($isDir);

            $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($iterator as $file):

                if($file->isFile()):

                    $R = explode(".", $file->getFileName());
                    // "Flexe\\App\\Endpoint\\City\\City"
                    $this->paths[strtolower(reset($R))] = sprintf("Flexe\\Helper\\%s\\%s", $module, reset($R));

                endif;

            endforeach;

        endif;
    }

    /**
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

}