<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Commons\Queries;

use Flexe\Db\Commons\Common;
use Flexe\Db\Init;

/**
 * Description of Delete
 *
 * @author caltj
 */
class Delete extends Common {

    private $ignore = false;

    public function __construct(Init $init, $table) {

        $clauses = [
            'DELETE FROM' => [$this, 'getClauseDeleteFrom'],
            'DELETE' => [$this, 'getClauseDelete'],
            'FROM' => null,
            'JOIN' => [$this, 'getClauseJoin'],
            'WHERE' => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT' => null,
        ];
        parent::__construct($init, $clauses);

        $this->statements['DELETE FROM'] = $table;
        $this->statements['DELETE'] = $table;
    }

    public function ignore() {

        $this->ignore = TRUE;

        return $this;
    }
    
    protected function buildQuery() {
        
        if(isset($this->statements['FROM'])):
            
            unset($this->clauses['DELETE FROM']);
        
        else:
            
            unset($this->clauses['DELETE']);
            
        endif;
        
        return parent::buildQuery();
    }
    
    
    public function execute() {
        
        $result = parent::execute();
        
        if($result):
            
            return $result->rowCount();
        
        endif;
        
        return FALSE;
    }
    
    protected function getClauseDelete(){
        
        $delete[] = 'DELETE ';

        if ($this->ignore):

            $delete[] = ' IGNORE';

        endif;

        $delete[] = $this->statements['DELETE'];

        return implode('', $delete);
    }
    
    
    protected function getClauseDeleteFrom(){
        
        $delete[] = 'DELETE ';

        if ($this->ignore):

            $delete[] = ' IGNORE';

        endif;

        $delete[] = ' FROM ';
        
        $delete[] = $this->statements['DELETE FROM'];

        return implode('', $delete);
    }

}
