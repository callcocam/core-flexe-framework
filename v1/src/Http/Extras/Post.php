<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 10:29
 */

namespace Flexe\Http\Extras;


use Slim\Http\Request;

class Post
{

    /**
     * @var Request
     */
    private $request;

    protected $Params = [];

    public function __construct(Request $request)
    {

        $this->request = $request;

        $this->Params = $this->request->getParsedBody();

        if(!$this->Params):

            $this->Params = [];

        endif;

    }

    /**
     * @return array|null|object
     */
    public function getParams()
    {
        return $this->Params;
    }

    /**
     * @param array|null|object $Params
     * @return Post
     */
    public function setParams($Params)
    {
        $this->Params = $Params;
        return $this;
    }

    public function isPost(){

        return $this->request->isPost();
    }
}