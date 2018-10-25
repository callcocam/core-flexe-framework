<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Helper;

/**
 * Description of TraitHelper
 *
 * @author caltj
 */
trait TraitHelper {

    private $keys = [];
    private $values = [];
    protected $path;

    protected function setKeys($keys) {
        $this->keys = explode("&", sprintf("{%s}",implode("}&{", array_keys($keys))));
        return $this;
    }

    protected function setValues($values) {
        $this->values = array_values($values);
        return $this;
    }

    protected function partial($template, $data = []): string {

        return $this->getFilesContent($template, $data);
    }

    private function getFilesContent($file, Array $data = []) {

        //config('files.ext')
        if (!file_exists(sprintf("%s%s.%s", $this->path, $file, 'phtml'))) {

            throw new \Exception(sprintf("template %s%s, not found", $this->path, $file));
        }

        $this->setKeys($data)->setValues($data);


        $Template = file_get_contents(sprintf("%s%s.%s", $this->path, $file, 'phtml'));

        return str_replace($this->keys, $this->values, $Template);
    }

}
