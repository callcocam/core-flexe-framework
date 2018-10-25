<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Extras;

/**
 * Description of Structure
 *
 * @author caltj
 */
class Structure {
   
    
    /** @var string */
    private $primaryKey;

    /** @var string */
    private $foreignKey;

    public function __construct($primaryKey = 'id', $foreignKey = "%s_id") {

        if ($foreignKey === NULL):

            $foreignKey = $primaryKey;

        endif;

        $this->primaryKey = $primaryKey;

        $this->foreignKey = $foreignKey;
        
    }

    public function getPrimaryKey($table) {

        return $this->key($this->primaryKey, $table);
    }

    public function getForeignKey($table) {

        return $this->key($this->foreignKey, $table);
    }

    private function key($key, $table) {

        if (is_callable($key)):

            return $key($table);

        endif;

        return sprintf($key, substr($table,0,-1));
    }

    
}
