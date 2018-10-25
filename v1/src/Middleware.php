<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/08/2018
 * Time: 11:15
 */

namespace Flexe;


use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Middleware
{

    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return mixed
     */
    abstract public function __invoke(Request $request, Response $response, $next);
}