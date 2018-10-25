<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Extras;

/**
 * Description of Literal
 *
 * @author caltj
 */
class Literal {

     /** @var string */
    protected $value = '';
    
    public function __construct($value) {
        
        $this->value = $value;
    }
    
    public function __toString() {
        
        return $this->value;
        
    }
}
