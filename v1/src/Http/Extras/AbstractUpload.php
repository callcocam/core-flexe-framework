<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 00:15
 */

namespace Flexe\Http\Extras;


use Flexe\Model\AbstractModel;
use Slim\Http\Request;

class AbstractUpload
{

    protected $Base;
    /**
     * @var Request
     */
    protected $Request;
    protected $NewFolder;
    protected $FileName;
    protected $Cover;
    protected $Controller;
    protected $Table = "images";
    protected $Model;
    protected $Body;


    /**
     * AbstractUpload constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->Base = sprintf("%s/%s%s", dirname(__DIR__, config('paths.nivel', 4)), config('paths.public', 'public_html'), config('files.path'));

        $this->Request = $request;

        $this->Model = new AbstractModel();

        $this->Body = $this->Request->getParsedBody();
    }

    /**
     * @return mixed
     */
    public function getNewFolder()
    {
        return $this->NewFolder;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->FileName;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->Cover;
    }

    protected function getPath($Folder, $FileName){

        $SubFolder = explode("/", $Folder);

        $this->NewFolder = '';

        if(count($SubFolder) > 1):

            foreach ($SubFolder as $sub):

                $this->NewFolder = $this->createPath($sub, $this->NewFolder);

            endforeach;

        endif;

        list($y, $m) = explode("/", date("Y/m"));

        $this->NewFolder = $this->createPath($y, $this->NewFolder);

        $this->NewFolder = $this->createPath($m, $this->NewFolder);

        return sprintf("%s/%s", $this->NewFolder, $FileName);
    }

    protected function createPath($Path, $NewFolder){

        $Dir = sprintf("%s%s/%s", $this->Base, $NewFolder, $Path);

        if(!is_dir($Dir)):

            mkdir($Dir);

        endif;

        return sprintf("%s/%s", $NewFolder, $Path);
    }

    protected function insert($data){

        if(isset($this->Body['id']) && (int)$this->Body['id']):

            $data['parent']         = $this->Body['id'];

            $data['company_id']     = $this->Body['company_id'];

            $data['updated_at']     = date("Y-m-d H:i:s");

            $Result                 = $this->Model->insert($this->Table,$data)->execute();

            if($Result):

                return false;

            endif;

        endif;
    }


    protected function listarFilesImages(){


        $Model =  $this->Model->from($this->Table)->where(
            [

                'assets'=>$this->Controller,

                'company_id'=>$this->Body['company_id'],

                'parent'=>$this->Body['id']

            ]
        );

        $Results  = $Model->findAll();

        if($Results):

            $Parents = [];

            foreach ($Results as $result):

                $Parents[] = $result['id'];

            endforeach;

            return implode(",", $Parents);

        endif;

    }



}













