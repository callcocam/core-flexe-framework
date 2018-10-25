<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/09/2018
 * Time: 09:25
 */

namespace Flexe\Views\Extras;


use Slim\Router;

class Url
{

    /**
     * @var null
     */
    private $parser;

    public function __construct($parser = null)
    {
        $this->parser = $parser;
    }

    public function url($route, $params = [],$queryParameters=[]){


        if($queryParameters):

            unset($queryParameters["status"],$queryParameters["start"],$queryParameters["end"],
                $queryParameters["column"],$queryParameters["order"],$queryParameters["limit"],
                $queryParameters["page"],$queryParameters["search"],$queryParameters["between"],
                $queryParameters["number"],$queryParameters["terminate"],$queryParameters["route"],$queryParameters["controller"]);

        endif;

        if(isset($queryParameters['query'])):

            $queryParameters = $queryParameters['query'];

            unset($queryParameters['query']);

        endif;

        return $this->parser->pathFor($route, $params, $queryParameters);
    }
}