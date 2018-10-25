<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 12:11
 */

namespace Flexe\Services;


use Flexe\Db\Extras\Structure;
use Flexe\Model\AbstractModel;

class Tenant extends AbstractModel
{

    protected $table = 'companys';

    protected $fillable = [
        'company_id',
        'tipo',
        'assets',
        'name',
        'alias',
        'email',
        'cover',
        'status',
        'description',
        'updated_at'
    ];
    protected $company=null;

    public function __construct(Structure $structure = null)
    {
        parent::__construct($structure);

        $this->company = $this->from()->where([
            'assets' =>__APP_SISTEMA__
        ])->find();

        if(!$this->company):

            $data['assets']         = __APP_SISTEMA__;
            $data['company_id']     = 1;
            $data['type']           = 1;
            $data['name']           = __APP_SISTEMA__;
            $data['alias']          = str_slug(__APP_SISTEMA__);
            $data['email']          = sprintf('admin@%s.com', __APP_SISTEMA__);
            $data['status']         = 1;
            $data['updated_at']     = date("Y-m-d H:i:s");

            $Result =  $this->insert()->values($data)->execute();

            $this->company = $this->from()->where([
                'assets' =>__APP_SISTEMA__
            ])->find();

            if($this->company):

                $this->update()->set([
                    'company_id'=>$Result
                ])->where([
                    'id' =>$Result
                ])->execute();

                $this->company = $this->from()->where([
                    'assets' =>__APP_SISTEMA__
                ])->find();

            endif;
        endif;
        if(!defined('COMPANYS_ID')){

            define('COMPANYS_ID', $this->company['id']);

        }

    }

    public function getCompany(){

        return $this->company;

    }

}