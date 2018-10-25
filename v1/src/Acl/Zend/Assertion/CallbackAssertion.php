<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace Zend\Permissions\Acl\Assertion;

use Flexe\Acl\Zend\Acl;
use Flexe\Acl\Zend\Exception\InvalidArgumentException;
use Flexe\Acl\Zend\Resource\ResourceInterface;
use Flexe\Acl\Zend\Role\RoleInterface;

class CallbackAssertion implements AssertionInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback The assertion callback
     */
    public function __construct($callback)
    {
        if (! is_callable($callback)) {
            throw new InvalidArgumentException('Invalid callback provided; not callable');
        }
        $this->callback = $callback;
    }

    /**
     * Returns true if and only if the assertion conditions are met.
     *
     * This method is passed the ACL, Role, Resource, and privilege to which the
     * authorization query applies.
     *
     * If the $role, $resource, or $privilege parameters are null, it means
     * that the query applies to all Roles, Resources, or privileges,
     * respectively.
     *
     * @param Acl               $acl
     * @param RoleInterface     $role
     * @param ResourceInterface $resource
     * @param string            $privilege
     *
     * @return bool
     */
    public function assert(
        Acl $acl,
        RoleInterface $role = null,
        ResourceInterface $resource = null,
        $privilege = null
    ) {
        return (bool) call_user_func($this->callback, $acl, $role, $resource, $privilege);
    }
}
