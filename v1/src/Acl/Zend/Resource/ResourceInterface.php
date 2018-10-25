<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */


namespace Flexe\Acl\Zend\Resource;

interface ResourceInterface
{
    /**
     * Returns the string identifier of the Resource
     *
     * @return string
     */
    public function getResourceId();
}
