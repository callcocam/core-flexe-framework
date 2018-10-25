<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/09/2018
 * Time: 11:02
 */

namespace Flexe\Acl;

use App\Admin\Model\PermissionModel;
use App\Admin\Model\ResourceModel;
use App\Admin\Model\RoleModel;
use Flexe\Acl\Zend\Acl as FlexeAcl,
    Flexe\Acl\Zend\Role\GenericRole as Role,
    Flexe\Acl\Zend\Resource\GenericResource as Resource;

class Acl extends FlexeAcl
{


    private $isAdmin;

    private $allRoles;

    /**
     * Acl constructor.
     * @param ResourceModel $resourceModel
     * @param RoleModel $roleModel
     * @param PermissionModel $permissionModel
     */
    public function __construct($resourceModel, $roleModel, $permissionModel)
    {

        $this->setRoles($roleModel);

        $this->setPrivileges($permissionModel);

    }

    /**
     * @param $Roles
     * @return Acl
     */
    public function setRoles($Roles)
    {


        if ($Roles):

            foreach ($Roles as $role) {

                //Verifica a role ja foi add
                if (!$this->hasRole((string)$role['id'])) {

                    //Inicia os parents da role ex:1 e parent da 2 a 2 da 3 etc
                    //a 1 herda da 2,3,4 e 5
                    $parentNames = array();

                    if (!is_null($role['role_id']) && (int)$role['role_id']) {

                        $parentNames = (string)$role['role_id'];

                    }
                    //Adiciana a role
                    $this->addRole(new Role((string)$role['id']), $parentNames);
                }
                //Se a role for admin conceda totos os privileges
                if ($role['is_admin']) {

                    $this->isAdmin[] = $role['id'];

                }

                $this->allRoles[] = $role['id'];

            }

            $this->deny($this->allRoles, null, null);

        endif;

        return $this;
    }

    public function setPrivileges($Privileges)
    {

        if ($Privileges):

            foreach ($Privileges as $privilege) {

               if (!$this->hasResource($privilege['route'])) {

                    $this->addResource(new Resource($privilege['route']));

                }

                $all_privileges = explode(",", $privilege['description']);

                $this->allow($privilege['role_id'], $privilege['route'], $all_privileges);

            }
        endif;

        if ($this->isAdmin):

            $this->allow($this->isAdmin, null, null);

            return $this;

        endif;

        return $this;
    }

    public function check($role, $resource, $method)
    {
        if(!$this->hasResource($resource)):

            return true;

        endif;

        return $this->isAllowed($role, $resource, $method);
    }
}