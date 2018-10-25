<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/09/2018
 * Time: 17:57
 */

namespace Flexe\Table;


class Row extends AbstractElement
{

    protected $actualRow;

    /**
     * Row constructor.
     * @param AbstractTable $table
     */
    public function __construct(AbstractTable $table)
    {
        $this->table = $table;

        $this->path = sprintf(config('table.templates','table'), __APP_DIR__, __APP_PROJECT__);

    }

    /**
     * @return mixed
     */
    public function getActualRow()
    {
        return $this->actualRow;
    }

    /**
     * @param mixed $actualRow
     * @return Row
     */
    public function setActualRow($actualRow)
    {
        $this->actualRow = $actualRow;
        return $this;
    }


    public function renderRow($type = 'html'){


        switch ($type):

            case 'html':

                return $this->renderHtml();

                break;

            case 'array':

                return $this->renderArray();

                break;

            case 'array_assc':

                return $this->renderArray('assc');

                break;
            default:

                throw new \InvalidArgumentException('type invalid');

                break;

        endswitch;

    }


    private function renderArray($type = 'normal')
    {
        $data =$this->table->getData();

        $headers = $this->table->getHeaders();


        $render = [];

        foreach ($data as $rowData) {

            $this->setActualRow($rowData);

            $temp = array();

            foreach ($headers as $name => $options) {

                if ($type == 'assc') {

                    $temp[$name] =  $this->table->getHeader($name)->getCell()->render('array');

                } else {

                    $temp[] =  $this->table->getHeader($name)->getCell()->render('array');

                }
            }

            $render[] = $temp;

        }

        return $render;
    }

    private function renderHtml(){

        $data =$this->table->getData();

        $headers = $this->table->getHeaders();


        $render = [];
        if($data):
            foreach ($data as $rowData):

                $this->setActualRow($rowData);

                $rowRender = [];

                foreach ($headers as $name => $options):

                    $rowRender[$name]= $this->table->getHeader($name)->getCell()->render('html');

                endforeach;

                $render[] =$this->partial(sprintf("%srow", $this->getTable()->getTheme()),[

                    'row'=>implode("", $rowRender)

                ]);
                $this->clearVar();
            endforeach;
        endif;

        return implode("", $render);
    }

}





















