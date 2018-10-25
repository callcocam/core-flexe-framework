<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace Flexe\Acl\Zend;

/**
 * Applicable to Resources and Roles.
 *
 * Provides information about the owner of some object. Used in conjunction
 * with the Ownership assertion.
 */
interface ProprietaryInterface
{
    /**
     * @return mixed
     */
    public function getOwnerId();
}
