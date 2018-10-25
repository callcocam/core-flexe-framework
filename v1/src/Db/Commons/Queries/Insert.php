<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Commons\Queries;

use Flexe\Db\Commons\AbstractCommons;
use Flexe\Db\Extras\Literal;
use Flexe\Db\Init;

/**
 * Description of Insert
 *
 * @author caltj
 */
class Insert extends AbstractCommons {

    /** @var array */
    private $columns = [];

    /** @var array */
    private $firstValue = [];

    /** @var bool */
    private $ignore = false;

    /** @var bool */
    private $delayed = false;

    public function __construct(Init $init, $table, $values) {

        $clauses = [
            'INSERT INTO' => array($this, 'getClauseInsertInto'),
            'VALUES' => array($this, 'getClauseValues'),
            'ON DUPLICATE KEY UPDATE' => array($this, 'getClauseOnDuplicateKeyUpdate')
        ];

        parent::__construct($init, $clauses);

        $this->statements['INSERT INTO'] = $table;

        $this->values($values);
    }

    public function execute($sequence = null) {

        $result = parent::execute();

        if ($result):

            return $this->getPDO()->lastInsertId($sequence);

        endif;
        return $result;
    }

    public function onDuplicateKeyUpdate($values) {

        $this->statements['ON DUPLICATE KEY UPDATE'] = array_merge(
                $this->statements['ON DUPLICATE KEY UPDATE'], $values
        );

        return $this;
    }

    public function values($values) {

        if (!is_array($values)):

            throw new \Exception('Param VALUES for INSERT query must be array');

        endif;

        $first = current($values);

        if (is_string(key($values))):

            $this->addOneValue($values);

        elseif (is_array($first) && is_string(key($first))):

            foreach ($values as $oneValue):

                $this->addOneValue($oneValue);

            endforeach;

        endif;

        return $this;
    }

    public function ignore() {

        $this->ignore = TRUE;

        return $this;
    }

    public function delayed() {

        $this->delayed = TRUE;

        return $this;
    }

    protected function getClauseInsertInto() {

        $insert[] = 'INSERT ';

        if ($this->ignore):

            $insert[] = ' IGNORE';

        endif;

        if ($this->delayed):

            $insert[] = ' DELAYED';

        endif;

        $insert[] = ' INTO ';

        $insert[] = $this->statements['INSERT INTO'];

        return implode('', $insert);
    }

    protected function parameterGetValue($param) {

        return $param instanceof Literal ? (string) $param : '?';
    }

    protected function getClauseValues() {

        $valueArray = [];

        foreach ($this->statements['VALUES'] as $rows):

            $placeholders = array_map(array($this, 'parameterGetValue'), $rows);

            $valueArray[] = sprintf("( %s )", implode(', ', $placeholders));

        endforeach;

        $columns = implode(", ", $this->columns);

        $values = implode(", ", $valueArray);

        return sprintf("(%s) VALUES %s", $columns, $values);
    }

    protected function filterLiterals($statement) {

        $f = function ($item) {

            return !$item instanceof Literal;
        };

        return array_map(function($item) use($f) {

            if (is_array($item)):

                return array_filter($item, $f);

            endif;

            return $item;
        }, array_filter($statement, $f));
    }

    protected function buildParameters() {

        $this->parameters = array_merge(
                $this->filterLiterals($this->statements['VALUES']), $this->filterLiterals($this->statements['ON DUPLICATE KEY UPDATE'])
        );

        return parent::buildParameters();
    }

    protected function getClauseOnDuplicateKeyUpdate() {

        $result = [];

        foreach ($this->statements['ON DUPLICATE KEY UPDATE'] as $key => $value):

            $result[] = sprintf("%s = %s", $key, $this->parameterGetValue($value));

        endforeach;

        return sprintf('ON DUPLICATE KEY UPDATE %s', implode(", ", $result));
    }

    private function addOneValue($oneValue) {

        foreach ($oneValue as $key => $value):

            if (!is_string($key)):

                throw new \Exception('INSERT query: All keys of value array have to be strings.');

            endif;

        endforeach;


        if (!$this->firstValue):

            $this->firstValue = $oneValue;

        endif;

        if (!$this->columns):

            $this->columns = array_keys($oneValue);

        endif;

        if ($this->columns != array_keys($oneValue)):

            throw new \Exception('INSERT query: All VALUES have to same keys (columns).');

        endif;

        $this->statements['VALUES'][] = $oneValue;
    }

}
