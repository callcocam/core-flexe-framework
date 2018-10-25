<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 01:23
 */

namespace Flexe\Auth;


use Flexe\Db\Extras\Utilities;
use Flexe\Db\Init;
use Flexe\Events\AuthEvent;
use Flexe\FlashMessenger;
use Flexe\Handlers\AuthHandler;
use Faker\Provider\pt_BR;
class Auth extends Init
{

    protected $table = "users";

    const FAILURE = 0;
    const FAILURE_IDENTITY_NOT_FOUND = 1;
    const FAILURE_IDENTITY_AMBIGUOUS = 2;
    const FAILURE_CREDENTIAL_INVALID = 3;
    const FAILURE_UNAUTHORIZED = 4;
    const SUCCESS = 5;


    protected $Result = [];

    protected $Code;

    protected $Type = "error";


    public function login($id, $login, $password){

        $this->Result = $this->from()->select('roles.alias as access, roles.is_admin as admin')->where([
            'users.email'=>$login,
            'users.company_id'=>$id
        ])->find();

        $this->Code = self::FAILURE_CREDENTIAL_INVALID;

        if($this->Result):

            if(!password_verify(sprintf("%s-%s", $password, $login), $this->Result['password'])):

                $this->Code = self::FAILURE_IDENTITY_NOT_FOUND;

            else:

                if(!$this->Result['status']):

                    $this->Code = self::FAILURE_IDENTITY_AMBIGUOUS;

                else:

                    $this->Code = self::SUCCESS;

                endif;

            endif;

        endif;

        return $this->Code;

    }

    public function getResult(){

        switch ($this->Code) {

            case self::FAILURE_IDENTITY_NOT_FOUND:
               $this->Type = FlashMessenger::NAMESPACE_WARNING;
                /** do stuff for nonexistent identity **/
                return "Sua identidade não foi encontrada, inexistente";
                break;

            case self::FAILURE_CREDENTIAL_INVALID:
                $this->Type = FlashMessenger::NAMESPACE_INFO;
                /** do stuff for invalid credential **/
                return "Credenciais inválidas, não foi encontrada, inexistente";
                break;

            case self::SUCCESS:
                $this->Type = FlashMessenger::NAMESPACE_SUCCESS;
                /** do stuff for successful authentication **/
                return "Autenticação bem-sucedida, credenciais verificadas com sucesso!";
                break;

            default:
                $this->Type = FlashMessenger::NAMESPACE_ERROR;
                /** do stuff for other failure **/
                return "Autenticação falhou, se você ja e cadastrado tente mais tarde";
                break;
        }

    }

    public function createAdminUserIfNotExists($company)
    {
        $Result = $this->from()->where( [
            'company_id'=>$company
        ])->findAll();

        if (!$Result) {
            $user['company_id'] = $company;
            $user['email'] = sprintf('admin@%s.com', __APP_SISTEMA__);
            $user['name'] = sprintf("Dr: %s", __APP_SISTEMA__);
            $user['role_id']        = $this->createRoleNotExists($company);
            $user['status'] = '1';
            $passwordHash =         Utilities::generate_hash(sprintf("%s-%s", 'Security',$user['email']));
            $user['password']       = $passwordHash;
            $user['updated_at']     = date('Y-m-d H:i:s');
            $userAdminId = $this->insert()->values($user)->execute();
            return $userAdminId;
        }


    }

    private function createRoleNotExists($company){

        $Companys = $this->from('companys')->where( [
            'id'=>$company
        ])->find();

        $Result = $this->from('roles')->where( [
            'company_id'=>$company
        ])->orderBy(" id DESC")->find();


        if (!$Result) {

            $cliente = [
                'company_id'=>$company['id'],
                'name'=> 'Cliente',
                'alias'=> 'cliente',
                'status'=>'1',
                'is_admin'=>'0',
                'description'=>'Usuário da parte front-end e que usa o site para adiquirir produtos ou serviços - '.$Companys['name'],
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($cliente)->execute();

            $assinante = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Assinante',
                'alias'=> 'assinante',
                'status'=>'1',
                'is_admin'=>'0',
                'description'=>"Usuário da parte front-end do sistema, e que pode ter acesso a novos conteudo sem ter que fazer um nova contratação- ".$Companys['name'],
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($assinante)->execute();

            $usuario_admin = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Usuário Admin',
                'alias'=> 'usuario-admin',
                'is_admin'=>'0',
                'description'=>"Secretárias, Vendedores e etc... - ".$Companys['name'],
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($usuario_admin)->execute();

            $colaborador = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Colaborador',
                'alias'=> 'colaborador',
                'status'=>'1',
                'is_admin'=>'0',
                'description'=>"Colobora com o gerente geral mas não tem todas a permissões dele - ".$Companys['name'],
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($colaborador)->execute();

            $gerente_geral = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Gerente Geral',
                'alias'=>'gerente-geral',
                'status'=>'1',
                'is_admin'=>'0',
                'description'=>"Gerencia o sistema correspondente - ".$Companys['name'],
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($gerente_geral)->execute();

            $administrador = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Administrador',
                'alias'=>'administrador',
                'is_admin'=>'0',
                'description'=>"Administra todo o sistema correspondente a ele - ".$Companys['name'],
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($administrador)->execute();

            $suporte_geral = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Suporte Geral',
                'alias'=> 'suporte-geral',
                'status'=>'1',
                'is_admin'=>'1',
                'description'=>"Auxilia o uso do sistema para colaboradores e funcionarios de toda a rede",
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($suporte_geral)->execute();

            $super_admin = [
                'company_id'=>$company,
                'role_id'=>$ResultId,
                'name'=> 'Super Admin',
                'alias'=>'super-admin',
                'status'=>'1',
                'is_admin'=>'1',
                'description'=>"Adminintrador geral de todos os sistemas",
                'updated_at'=> \Carbon\Carbon::create()
            ];

            $ResultId = $this->insert('roles')->values($super_admin)->execute();

            return $ResultId;
        }
        return $Result['id'];
    }

    public function setStorage(){

        $event = new AuthEvent($this->Result);

        $event->attach(new AuthHandler());

        $event->dispatch();

        return $this->Result;
    }



}