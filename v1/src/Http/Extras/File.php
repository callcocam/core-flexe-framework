<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/09/2018
 * Time: 00:10
 */

namespace Flexe\Http\Extras;


use Slim\Http\UploadedFile;

class File extends AbstractUpload
{


    protected $Table = 'files';
    /**
     * @param string $Controller
     * @return array
     */
    public function getFile($Controller = "posts"){

        $this->Controller = $Controller;
        /**
         * @var UploadedFile $Image
         */

        $Image = null;

        $Files = $this->Request->getUploadedFiles();

        if(isset($Files['file'])):

            if($Files['file']):

                $Image = $Files['file'];

                if(!empty($Image->getClientFilename())):

                    $Name = explode(".", $Image->getClientFilename());

                    $id = isset($this->Body['id'])?$this->Body['id']:rand(1,10000);

                    $Folder = $this->getPath(config('files.file'),
                        sprintf("%s-%s.%s", str_pad($id, 5, '0', STR_PAD_LEFT),
                            str_slug(reset($Name)), end($Name)));

                    $Image->moveTo(sprintf("%s/%s", $this->Base, $Folder));

                    if(!$Image->getError()):

                        $data['name'] = reset($Name);

                        $data['assets'] = $this->Controller;

                        $data['type'] = $Image->getClientMediaType();

                        $data['width'] = $Image->getSize();

                        $data['folder'] = $this->getNewFolder();

                        $data['link'] =$Folder;

                        $data['file'] = $this->insert($data);

                        unset($data['name'],$data['type'],$data['width'],$data['link'],$data['assets']);

                    endif;

                endif;

            endif;
            return ['file'=>$this->listarFilesImages()];
        endif;

        return [];

    }
}