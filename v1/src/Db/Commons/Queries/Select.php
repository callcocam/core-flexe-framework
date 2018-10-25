<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Commons\Queries;

use Flexe\Db\Commons\Common;
use Flexe\Db\Extras\Utilities;
use Flexe\Db\Init;

/**
 * Description of Select
 *
 * @author caltj
 */
class Select extends Common implements \Countable {

    private $fromTable;
    private $fromAlias;
    private $convertTypes = false;

    public function __construct(Init $init, $from) {

        $clauses = [
            'SELECT' => ', ',
            'FROM' => NULL,
            'JOIN' => [$this, 'getClauseJoin'],
            'WHERE' => ' AND ',
            'GROUP BY' => ',',
            'HAVING' => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT' => NULL,
            'OFFSET' => NULL,
            '\n--' => '\n--'
        ];

        parent::__construct($init, $clauses);

        $fromParts = explode(' ', $from);

        $this->fromTable = reset($fromParts);

        $this->fromAlias = end($fromParts);

        $this->statements['FROM'] = $from;

        $this->statements['SELECT'][] = sprintf("%s.*", $this->fromAlias);

        $this->joins[] = $this->fromAlias;

        if (isset($init->convertTypes) && $init->convertTypes):

            $this->convertTypes = TRUE;

        endif;
    }

    public function between($field,$params){

        $this->where([

            sprintf(" %s.%s >= ? ", $this->getFromAlias(), $field) => $params[0]

        ])->where([

            sprintf(" %s.%s <= ? ", $this->getFromAlias(), $field) => $params[1]

        ]);

        return $this;
    }

    public function getFromTable() {
        return $this->fromTable;
    }

    public function getFromAlias() {
        return $this->fromAlias;
    }
    /**
     * Returns a single column
     *
     * @param int $columnNumber
     *
     * @return string
     */
    public function fetchColumn($columnNumber = 0) {
        if (($s = $this->execute()) !== false) {
            return $s->fetchColumn($columnNumber);
        }

        return $s;
    }

    public function find($column = '') {

        $s = $this->execute();

        if ($s === FALSE):

            return FALSE;

        endif;

        $row = $s->fetch();

        if ($row && $column != ''):

            if (is_object($row)):

                return $row->{$column};

            else:

                return $row[$column];

            endif;

        endif;

        return $row;
    }

    public function findAll($index = '', $selectOnly = '') {

        if ($selectOnly):

            $this->select(NULL)->select(sprintf("%s, %s", $index, $selectOnly));

        endif;

        if ($index):

            $data = [];

            foreach ($this as $row):

                if (is_object($row)):

                    $data[$row->{$index}] = $row;

                else:

                    $data[$row[$index]] = $row;

                endif;

                return $data;

            endforeach;

        else:

            if (($s = $this->execute()) !== FALSE):

                if ($this->convertTypes):

                    return Utilities::convertTypes($s, $s->fetchAll());

                else:

                    return $s->fetchAll();

                endif;
            endif;

            return $s;

        endif;
    }

    /**
     * Fetch pairs
     *
     * @param $key
     * @param $value
     * @param $object
     *
     * @return array of fetched rows as pairs
     */
    public function fetchPairs($key, $value, $object = false) {
        if (($s = $this->select(null)->select("$key, $value")->asObject($object)->execute()) !== false) {
            return $s->fetchAll(\PDO::FETCH_KEY_PAIR);
        }

        return $s;
    }
    /**
     * \Countable interface doesn't break current select query
     *
     * @return int
     */
    public function count() {
        $fluent = clone $this;

        return (int)$fluent->select(null)->select('COUNT(*)')->fetchColumn();
    }

}
