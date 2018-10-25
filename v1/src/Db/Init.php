<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db;

use Flexe\Db\Extras\Structure;
use Flexe\Db\Extras\Utilities;

/**
 * Description of Init
 *
 * @author caltj
 */
class Init {

    use ConnectTrait;

    protected $pdo;
    protected $structure;
    public $debug = false;
    public $convertTypes = false;
    protected $fillable;
    protected $table;

    public function __construct(Structure $structure = null) {

        $this->pdo = $this->connect();

        if (!$structure):

            $structure = new Structure();

        endif;

        $this->structure = $structure;
    }

    public function exchangeArray($data){
        if(!$this->fillable):
            throw new \Exception("verificação de segurnça contra [ Mass Assignment ], informe na model de [{$this->table}] os cmpos qe serão modificados");
        endif;
        return Utilities::fillable($this->fillable, $data);
    }
    /**
     * 
     * @param string $table nome da tabela
     * @param mixed $primaryKey valor da chave primaria
     * @return Commons\Queries\Select
     */
    public function from($table = null, $primaryKey = null) {

        if(empty($table)):

            $table = $this->table;

        endif;

        $query = new Commons\Queries\Select($this, $table);

        if ($primaryKey == !NULL):

            $tableName = $query->getFromTable();

            $tableAlias = $query->getFromAlias();

            $primaryKeyName = $this->structure->getPrimaryKey($tableName);

            $query = $query->where(sprintf("%s.%s", $tableAlias, $primaryKeyName), $primaryKey);

            if (!empty(__APP_SISTEMA__)) {
                if (defined('COMPANYS_ID')) {
                    $query  = $query->where([
                        'company_id'=>COMPANYS_ID
                    ]);
                }
            }

        endif;

        return $query;
    }

    /**
     * Create INSERT INTO query
     *
     * @param string $table
     * @param array $values - accepts one or multiple rows, @see docs
     *
     * @return Commons\Queries\Insert
     */
    public function insert($table = null, $values = []) {

        if(empty($table)):

            $table = $this->table;

        endif;

        $query = new Commons\Queries\Insert($this, $table, $values);

        return $query;
    }

    /**
     * Create UPDATE query
     *
     * @param string $table
     * @param array|string $set
     * @param string $primaryKey
     *
     * @return Update
     * @throws \Exception
     */
    public function update($table = null, $set = [], $primaryKey = null) {
        if(empty($table)):

            $table = $this->table;

        endif;
        $query = new Commons\Queries\Update($this, $table);

        $query->set($set);

        if ($primaryKey):

            $primaryKeyName = $this->getStructure()->getPrimaryKey($table);

            $query = $query->where($primaryKeyName, $primaryKey);

        endif;

        return $query;
    }
    
     /**
     * Create DELETE query
     *
     * @param string $table
     * @param string $primaryKey delete only row by primary key
     *
     * @return Delete
     */
    public function delete($table = null, $primaryKey = null) {

        if(empty($table)):

            $table = $this->table;

        endif;

        $query = new Commons\Queries\Delete($this, $table);
       
        if ($primaryKey) {
            
            $primaryKeyName = $this->getStructure()->getPrimaryKey($table);
            
            $query          = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    public function getStructure() {

        return $this->structure;
    }

    /**
     * 
     * @return \PDO
     */
    public function getPdo(): \PDO {

        return $this->pdo;
    }

    public function close() {

        $this->pdo = NULL;
    }

}
