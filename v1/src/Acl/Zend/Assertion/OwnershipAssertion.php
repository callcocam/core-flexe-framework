<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace Flexe\Acl\Zend\Assertion;

use Flexe\Acl\Zend\Acl;
use Flexe\Acl\Zend\Role\RoleInterface;
use Flexe\Acl\Zend\Resource\ResourceInterface;
use Flexe\Acl\Zend\ProprietaryInterface;

/**
 * Makes sure that some Resource is owned by certain Role.
 */
class OwnershipAssertion implements AssertionInterface
{
    public function assert(Acl $acl, RoleInterface $role = null, ResourceInterface $resource = null, $privilege = null)
    {
        //Assert passes if role or resource is not proprietary
        if (! $role instanceof ProprietaryInterface || ! $resource instanceof ProprietaryInterface) {
            return true;
        }

        //Assert passes if resources does not have an owner
        if ($resource->getOwnerId() === null) {
            return true;
        }

        return ($resource->getOwnerId() === $role->getOwnerId());
    }
}
