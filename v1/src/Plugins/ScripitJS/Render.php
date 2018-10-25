<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 16/09/2018
 * Time: 12:20
 */

namespace Flexe\Plugins\ScripitJS;


class Render
{

    protected $scripts = [];
    protected $data;
    protected $defaultExt = 'phtml';
    protected $path;

    /**
     * @return array
     * @throws \Exception
     */
    public function getScripts(): array
    {

        $scripts = [];

        $this->path = sprintf("%s/src/views/partials/script", dirname(__DIR__, 3));

        if($this->scripts):

            foreach ($this->scripts as $script):

                $scripts[] = $this->render($script, $this->data);

            endforeach;

        endif;

        return $scripts;
    }

    /**
     * @param array $scripts
     * @return Render
     */
    public function setScripts(array $scripts): Render
    {
        $this->scripts[] = $scripts;
        return $this;
    }

    public function render($template, $data = []){


        if (!file_exists(sprintf("%s%s.%s", $this->path, sprintf("partials/%s",$template), $this->defaultExt))):

            throw new \Exception(sprintf("template %s/%s.%s not found", $this->path, $template, $this->defaultExt));

        endif;

        $data = array_merge($this->data, $data);

        if ($data):

            extract($data);

        endif;

        ob_start();

        include sprintf("%s/%s.%s", $this->path, $template, $this->defaultExt);

        return ob_get_clean();
    }

    public function __toString()
    {
        return implode(PHP_EOL, $this->getScripts());
    }

}