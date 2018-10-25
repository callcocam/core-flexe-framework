<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Commons\Queries;

use Flexe\Db\Commons\Common;
use Flexe\Db\Extras\Literal;
use Flexe\Db\Init;

/**
 * Description of Update
 *
 * @author caltj
 */
class Update extends Common {

    public function __construct(Init $init, $table) {

        $clauses = [
            'UPDATE' => [$this, 'getClauseUpdate'],
            'JOIN' => [$this, 'getClauseJoin'],
            'SET' => [$this, 'getClauseSet'],
            'WHERE' => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT' => null,
        ];

        parent::__construct($init, $clauses);

        $this->statements['UPDATE'] = $table;

        $tableParts = explode(' ', $table);

        $this->joins[] = end($tableParts);
    }

    public function set($fieldOrArray, $value = false) {

        if (!$fieldOrArray):

            return $this;

        endif;

        if (is_string($fieldOrArray) && $value !== FALSE):

            $this->statements['SET'][$fieldOrArray] = $value;

        else:

            if (!is_array($fieldOrArray)):

                throw new \Exception('You must pass a value, or provide the SET list as an associative array. column => value');

            else:

                foreach ($fieldOrArray as $filed => $values):

                    $this->statements['SET'][$filed] = $values;

                endforeach;

            endif;
        endif;

        return $this;
    }

    public function execute($getResultAsPdoStatement = false) {

        $result = parent::execute();

        if ($getResultAsPdoStatement):

            return $result;

        endif;

        if ($result):

            return $result->rowCount();

        endif;

        return FALSE;
    }

    protected function getClauseUpdate() {

        return sprintf(" UPDATE %s", $this->statements['UPDATE']);
    }

    public function getClauseSet() {

        $setArray = [];

        foreach ($this->statements['SET'] as $field => $value):

            if ($value instanceof Literal):

                $setArray[] = sprintf("%s = %s", $field, $value);

            else:

                $setArray[] = sprintf("%s = ?", $field);

                $this->parameters['SET'][$field] = $value;

            endif;

        endforeach;

        return sprintf(" SET %s", implode(", ", $setArray));
    }

}
