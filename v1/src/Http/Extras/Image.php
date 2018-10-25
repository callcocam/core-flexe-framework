<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 00:10
 */

namespace Flexe\Http\Extras;


use Slim\Http\UploadedFile;

class Image extends AbstractUpload
{


    /**
     * @param $Controller
     * @return array
     */
    public function getImage($Controller = "posts"){

        $this->Controller = $Controller;
        /**
         * @var UploadedFile $Image
         */

        $Image = null;

        $Files = $this->Request->getUploadedFiles();

        if(isset($Files['image'])):

            if($Files['image']):

                $Image = $Files['image'];

                if(!empty($Image->getClientFilename())):

                    $Name = explode(".", $Image->getClientFilename());

                    $Folder = $this->getPath(config('files.image'),sprintf("%s.%s", str_slug(reset($Name)), end($Name)));

                    $Image->moveTo(sprintf("%s/%s", $this->Base, $Folder));

                    if(!$Image->getError()):

                        $data['name'] = reset($Name);

                        $data['assets'] = $this->Controller;

                        $data['type'] = $Image->getClientMediaType();

                        $data['width'] = $Image->getSize();

                        $data['folder'] = $this->getNewFolder();

                        $data['link'] =$Folder;

                        $this->Model->delete($this->Table)->where([

                            'assets'=>$this->Controller,

                            'company_id'=>$this->Body['company_id'],

                            'parent'=>$this->Body['id']

                        ])->execute();

                        $this->insert($data);

                        unset($data['name'],$data['type'],$data['width'],$data['link'],$data['assets']);

                        $data['cover'] =$Folder;

                        return $data;

                    endif;

                endif;

            endif;

        endif;

        return [];
    }
}