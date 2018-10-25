<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 17/09/2018
 * Time: 00:34
 */

namespace Flexe\Plugins\Fullcalendar;


class View
{
    private $view;
    /**
     * @var array
     */
     private $path;


    public function render($view,$data=[]){

        $this->path = sprintf("%s/views/", __DIR__);

        return $this->getFilesContent($view, $data);

    }

    private function getFilesContent($file, Array $data=[]){
        if(!file_exists(sprintf("%s%s.phtml", $this->path, $file))){
            throw new \Exception(sprintf("template %s%s, not found", $this->path, $file));
        }

        if($data)
            extract($data);

        include sprintf("%s%s.phtml", $this->path, $file);
    }

}