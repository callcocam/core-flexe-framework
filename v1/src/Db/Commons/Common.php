<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Commons;

use Flexe\Db\Extras\Literal;
use Flexe\Db\Extras\Utilities;

/**
 * Description of Common
 *
 * @author caltj
 */
class Common extends AbstractCommons {

    private $validMethods = [
        'from',
        'fullJoin',
        'group',
        'groupBy',
        'having',
        'innerJoin',
        'join',
        'leftJoin',
        'limit',
        'offset',
        'order',
        'orderBy',
        'outerJoin',
        'rightJoin',
        'select'
    ];
    protected $joins = [];

    /** @var bool - Desativar a adição de associações indefinidas para consultar? */
    protected $isSmartJoinEnabled = true;

    /**
     * @return $this
     */
    public function enableSmartJoin() {
        $this->isSmartJoinEnabled = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function disableSmartJoin() {
        $this->isSmartJoinEnabled = false;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSmartJoinEnabled() {
        return $this->isSmartJoinEnabled;
    }

    public function where($condition, $parameters = []) {

        if ($condition === NULL):

            return $this->resetClause('WHERE');

        endif;

        if (!$condition):

            return $this;

        endif;

        if (is_array($condition)):

            foreach ($condition as $key => $value):

                $this->where($key, $value);

            endforeach;

            return $this;

        endif;

        $args = func_get_args();

        if (count($args) == 1):

            return $this->addStantement('WHERE', $condition);

        endif;

        /*
          Verifique se há dois argumentos, uma condição e um valor de parâmetro. Se a condição contiver
          um parâmetro, adicione-os; cabe ao dev ser sql válido. Caso contrário, é provavelmente
          apenas um identificador, portanto, construa uma nova condição com base no valor do parâmetro passado.
         * 
         */
        if (count($args) == 2 && !preg_match('/(\?|:\w+)/i', $condition)):

            if (is_null($parameters)):

                return $this->addStantement("WHERE", sprintf("%s is NULL", $condition));

            elseif ($args[1] === []):

                return $this->addStantement("WHERE", 'FALSE');

            elseif (is_array($args[1])):

                $in = $this->quote($args[1]);

                return $this->addStantement("WHERE", sprintf("%s IN %s", $condition, $in));

            endif;

            if ($parameters instanceof Literal):

                $condition = sprintf("%s = %s", $condition, $parameters);

                return $this->addStantement("WHERE", $condition);

            else:

                $condition = sprintf("%s = ?", $condition);

            endif;

        endif;

        array_shift($args);

        return $this->addStantement("WHERE", $condition, $args);
    }

    public function __call($name, $parameters = []) {

        if (!in_array($name, $this->validMethods)):

            trigger_error("Call to invalid method " . get_class($this) . "::{$name}()", E_USER_ERROR);

        endif;

        $clause = Utilities::toUpperWords($name);

        if ($clause == "GROUP"):

            $clause = "GROUP BY";

        endif;
        if ($clause == "ORDER"):

            $clause = "ORDER BY";

        endif;

        if ($clause == "FOOT NOTE"):

            $clause = "\n--";

        endif;

        $statement = array_shift($parameters);

        if (strpos($clause, 'JOIN') !== FALSE):

            return $this->addJoinStatements($clause, $statement, $parameters);

        endif;

        return $this->addStantement($clause, $statement, $parameters);
    }

    protected function getClauseJoin() {

        return implode(" ", $this->statements['JOIN']);
    }

    private function addJoinStatements($clause, $statement, $parameters = []) {

        if ($statement === NULL):

            $this->joins = [];

            return $this->resetClause("JOIN");

        endif;

        if (array_search(substr($statement, 0, -1), $this->joins) !== FALSE):

            return $this;

        endif;

        preg_match('/`?([a-z_][a-z0-9_\.:]*)`?(\s+AS)?(\s+`?([a-z_][a-z0-9_]*)`?)?/i', $statement, $matches);

        $joinTable = '';
        $joinAlias = '';

        if ($matches):

            $joinTable = $matches[1];

            if (isset($matches[4]) && !in_array($matches[4], ['ON', 'USING'])):

                $joinAlias = $matches[4];

            endif;

        endif;

        if (strpos(strtoupper($statement), ' ON ') || strpos(strtoupper($statement), ' USING ')):

            if (!$joinAlias):

                $joinAlias = $joinTable;

            endif;

            if (in_array($joinAlias, $this->joins)):

                return $this;

            else:

                $this->joins[] = $joinAlias;

                $statement = sprintf(" %s %s", $clause, $statement);

                return $this->addStantement("JOIN", $statement, $parameters);

            endif;
        endif;

        if (!in_array(substr($joinTable, -1), ['.', ':'])):

            $joinTable .= '.';

        endif;

        preg_match_all('/([a-z_][a-z0-9_]*[\.:]?)/i', $joinTable, $matches);

        $mainTable = '';

        if (isset($this->statements['FROM'])):

            $mainTable = $this->statements['FROM'];

        elseif (isset($this->statements['UPDATE'])):

            $mainTable = $this->statements['UPDATE'];

        endif;

        $lastItem = array_pop($matches[1]);

        array_push($matches[1], $lastItem);

        foreach ($matches[1] as $joinItem):

            if ($mainTable == substr($joinItem, 0, -1)):

                continue;

            endif;

            $alias = '';

            if ($joinItem == $lastItem):

                $alias = $joinAlias;

            endif;

            $newJoin = $this->createJoinStatement($clause, $mainTable, $joinItem, $alias);

            if ($newJoin):

                $this->addStantement("JOIN", $newJoin, $parameters);

            endif;

            $mainTable = $joinItem;

        endforeach;

        return $this;
    }

    private function createJoinStatement($clause, $mainTable, $joinTable, $joinAlias) {

        if (in_array(substr($mainTable, -1), [':', '.'])):

            $mainTable = substr($mainTable, 0, -1);

        endif;

        $referenceDirection = substr($joinTable, -1);

        $joinTable = substr($joinTable, 0, -1);

        $asJoinAlias = '';

        if ($joinAlias):

            $asJoinAlias = sprintf(" AS %s", $joinAlias);

        else:

            $joinAlias = $joinTable;

        endif;

        if (in_array($joinAlias, $this->joins)):

            return '';

        else:

            $this->joins[] = $joinAlias;

        endif;

        if ($referenceDirection == ':'):

            $primaryKey = $this->getStructure()->getPrimaryKey($mainTable);
            $foreignKey = $this->getStructure()->getForeignKey($mainTable);

            return sprintf(" %s %s%s ON %s.%s = %s.%s", $clause, $joinTable, $asJoinAlias, $joinAlias, $foreignKey, $mainTable, $primaryKey);

        else:

            $primaryKey = $this->getStructure()->getPrimaryKey($joinTable);
            $foreignKey = $this->getStructure()->getForeignKey($joinTable);

            return sprintf(" %s %s%s ON %s.%s = %s.%s", $clause, $joinTable, $asJoinAlias, $joinAlias, $primaryKey, $mainTable, $foreignKey);

        endif;
    }

    protected function buildQuery() {

        $statementsWithReferences = ['WHERE', 'SELECT', 'GROUP BY', 'ORDER BY'];

        foreach ($statementsWithReferences as $clause):

            if (array_key_exists($clause, $this->statements)):

                $this->statements[$clause] = array_map(array($this, 'createUndefinedJoins'), $this->statements[$clause]);

            endif;

        endforeach;

        return parent::buildQuery();
    }

    private function createUndefinedJoins($statement) {

        if (!$this->isSmartJoinEnabled):

            return $statement;

        endif;

        preg_match_all('/([^[:space:]\(\)]+[.:])[\p{L}\p{N}\p{Pd}\p{Pi}\p{Pf}\p{Pc}]*/u', $statement, $matches);

        foreach ($matches[1] as $join):

            if (!in_array(substr($join, 0, -1), $this->joins)):

                $this->addJoinStatements('LEFT JOIN', $join);

            endif;

        endforeach;
        
        foreach ($this->joins as $join):
            
            if(strpos($join, '.') !== FALSE && strpos($statement, $join) === 0):
                
                return $statement;
                
            endif;
        endforeach;
        
        $statement =  preg_replace('/(?:[^\s]*[.:])?([^\s]+)[.:]([^\s]*)/u', '$1.$2', $statement);
        
        return $statement;
    }

}
