<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 01/09/2018
 * Time: 09:19
 */

namespace Flexe\Commands;


trait TraitCommands
{

    protected $aFind = [];
    protected $aSub = [];
    protected $Default = [
        "S_Name" => '',
        "S_Demo" => '',
        "S_route" => '',
        "S_controller" => '',
    ];
    protected $newName;
    protected $data;


    protected function copyemz($file1,$vendor, $file2)
    {
        $contentx = str_replace($this->aFind, $this->aSub, file_get_contents($file1));

        $openedfile = fopen(sprintf("%s/%s/%s",dirname(__DIR__, 3), $vendor, $file2), "w");

        fwrite($openedfile, $contentx);

        fclose($openedfile);

        if ($contentx === FALSE) {

            $status = false;

        } else{

            $status = true;

        }
        return $file2;
    }

    /**
     * @param $directory
     * @param $item
     * @return string
     */
    protected function getDirectory($directory, $item)
    {
        return sprintf("%s/%s", $directory, $item);
    }


    /**
     * @param $destine
     * @param $item
     * @return string
     */
    protected function getDestine($destine, $item)
    {
        $itemDest = str_replace(["Demo", "demo", "S_name"], [$this->filteredName($this->newName), strtolower($this->data['controller']), strtolower($this->newName)], $item);
        return sprintf("%s/%s", $destine, $itemDest);
    }

    public function getToNativeNames(\PDOStatement $statement)
    {
        $rows = [];

        for ($i = 0; ($columnMeta = $statement->getColumnMeta($i)) !== false; $i++)
        {
            $type = $columnMeta['native_type'];

            $rows[$columnMeta['name']] = $columnMeta['name'];


        }
        return implode("','",$rows);
    }

    public function getToNativeNamesTable(\PDOStatement $statement,$table)
    {
        $rows = [];

        for ($i = 0; ($columnMeta = $statement->getColumnMeta($i)) !== false; $i++)
        {

            $rows[$columnMeta['name']] = sprintf("'%ss_%s' => ['name' => '%s','title' => '%s'],", $table, $columnMeta['name'], $columnMeta['name'], $columnMeta['name']);


        }
        return implode("','",$rows);
    }

    /**
     * Processo de tratamento para o mecanismo MVC
     * @param string $input String que será convertida
     * @return string           String convertida
     */
    protected function filteredName(string $input): string
    {
//        $input = explode('?', $input);
//        $input = $input[0];
        $find = [
            '-',
            '_'
        ];
        $replace = [
            ' ',
            ' '
        ];
        return str_replace(' ', '', ucwords(str_replace($find, $replace, $input)));
    }

    protected function filteredFileName(string $input): string
    {
        $input = trim($input);
        //Remove " caso exista
        $new = str_replace('&#34;', '', $input);
        $find = [
            '  ',
            '"',
            'á',
            'ã',
            'à',
            'â',
            'ª',
            'é',
            'è',
            'ê',
            'ë',
            'í',
            'ì',
            'î',
            'ï',
            'ó',
            'ò',
            'õ',
            'ô',
            '°',
            'º',
            'ö',
            'ú',
            'ù',
            'û',
            'ü',
            'ç',
            'ñ',
            'Á',
            'Ã',
            'À',
            'Â',
            'É',
            'È',
            'Ê',
            'Ë',
            'Í',
            'Ì',
            'Î',
            'Ï',
            'Ó',
            'Ò',
            'Õ',
            'Ô',
            'Ö',
            'Ú',
            'Ù',
            'Û',
            'Ü',
            'Ç',
            'Ñ',
        ];
        $replace = [
            '',
            '',
            'a',
            'a',
            'a',
            'a',
            'a',
            'e',
            'e',
            'e',
            'e',
            'i',
            'i',
            'i',
            'i',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'u',
            'u',
            'u',
            'u',
            'c',
            'n',
            'A',
            'A',
            'A',
            'A',
            'E',
            'E',
            'E',
            'E',
            'I',
            'I',
            'I',
            'I',
            'O',
            'O',
            'O',
            'O',
            'O',
            'U',
            'U',
            'U',
            'U',
            'C',
            'N',
        ];
        return strtolower(str_replace(' ', '_', str_replace($find, $replace, $new)));
    }

}