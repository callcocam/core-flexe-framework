<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Commons;

use Flexe\Db\Extras\Literal;
use Flexe\Db\Extras\Structure;
use Flexe\Db\Extras\Utilities;
use Flexe\Db\Init;
use Flexe\Storage\Session;

/**
 * Description of AbstractCommons
 *
 * @author caltj
 */
class AbstractCommons {

    private $init;
    private $result;
    private $object = false;
    protected $error;
    protected $time;
    protected $clauses = [];
    protected $statements = [];
    protected $parameters = [];

    public function __construct(Init $init, $clauses) {

        $this->init = $init;

        $this->clauses = $clauses;

        $this->initClauses();
    }

    public function __toString() {

        return $this->getQuery();
    }

    private function initClauses() {

        foreach ($this->clauses as $clause => $value):

            if ($value):
                $this->statements[$clause] = [];
                $this->parameters[$clause] = [];
            else:
                $this->statements[$clause] = NULL;
                $this->parameters[$clause] = NULL;
            endif;

        endforeach;
    }

    protected function addStantement($clause, $statement, $parameters = []) {

        if ($statement === NULL):

            return $this->resetClause($clause);

        endif;

        if ($this->clauses[$clause]):

            if (is_array($statement)):

                $this->statements[$clause] = array_merge($this->statements[$clause], $statement);

            else:

                $this->statements[$clause][] = $statement;

            endif;

            $this->parameters[$clause] = array_merge($this->parameters[$clause], $parameters);

        else:

            $this->statements[$clause] = $statement;

            $this->parameters[$clause] = $parameters;

        endif;
        return $this;
    }

    protected function resetClause($clause) {

        $this->statements[$clause] = NULL;

        $this->parameters[$clause] = [];

        if (isset($this->clauses[$clause]) && $this->clauses[$clause]):

            $this->statements[$clause] = [];

        endif;

        return $this;
    }

    public function getIterator() {

        return $this->execute();
    }

    public function execute() {

        $query = $this->buildQuery();

        $parameters = $this->buildParameters();

        $result = $this->init->getPdo()->prepare($query);

        if ($this->object == !FALSE):

            if (class_exists($this->object)):

                $result->setFetchMode(\PDO::FETCH_CLASS, $this->object);

            else:

                $result->setFetchMode(\PDO::FETCH_OBJ);

            endif;
        elseif ($this->init->getPdo()->getAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE) == \PDO::FETCH_BOTH):

            $result->setFetchMode(\PDO::FETCH_ASSOC);

        endif;


        $time = microtime(TRUE);

      try{
          if ($result && $result->execute($parameters)):

              $this->time = microtime(TRUE) - $time;

          else:

              $result = FALSE;

          endif;

      }catch (\PDOException $exception){

          $result = false;

          $this->error = sprintf("%s  - %s", $exception->getCode(), $exception->getMessage());

          $session = Session::factory();

          $session->set('error',$this->error);

          if ($this->init->debug) {
              dd($this->error);
          }
      }

        $this->result = $result;

        $this->debugger();

        return $result;
    }

    public function debugger() {
        if ($this->init->debug) {
            if (!is_callable($this->init->debug)) {
                $backtrace  = '';
                $query      = $this->getQuery();
                $parameters = $this->getParameters();
                $debug      = '';
                if ($parameters) {
                    $debug = '# parameters: ' . implode(', ', array_map(array($this, 'quote'), $parameters)) . "\n";
                }
                $debug .= $query;
                $pattern = '(^' . preg_quote(__DIR__) . '(\\.php$|[/\\\\]))'; // can be static
                foreach (debug_backtrace() as $backtrace) {
                    if (isset($backtrace['file']) && !preg_match($pattern, $backtrace['file'])) {
                        // stop on first file outside Query source codes
                        break;
                    }
                }
                $time = sprintf('%0.3f', $this->time * 1000) . ' ms';
                $rows = ($this->result) ? $this->result->rowCount() : 0;
                $finalString = "# $backtrace[file]:$backtrace[line] ($time; rows = $rows)\n$debug\n\n";
                if (defined('STDERR')) { // if STDERR is set, send there, otherwise just output the string
                    if (is_resource(STDERR)) {
                        fwrite(STDERR, $finalString);
                    }
                    else {
                        echo $finalString;
                    }
                }
                else {
                    echo $finalString;
                }
            } else {
                call_user_func($this->init->debug, $this);
            }
        }
    }

    protected function buildQuery() {

        $query = '';

        foreach ($this->clauses as $clause => $separator):

            if ($this->clauseNotEmpty($clause)):

                if (is_string($separator)):

                    $query .= sprintf(" %s %s ", $clause, implode($separator, $this->statements[$clause]));

                elseif ($separator === NULL):

                    $query .= sprintf(" %s %s ", $clause, $this->statements[$clause]);

                elseif (is_callable($separator)):

                    $query .= call_user_func($separator);

                else:

                    throw new \Exception("Clause '$clause' is incorrectly set to '$separator'.");

                endif;


            endif;

        endforeach;

        return trim($query);
    }

    protected function buildParameters() {

        $parameters = [];

        foreach ($this->parameters as $clauses):

            if (is_array($clauses)):

                foreach ($clauses as $value):

                    if (is_array($value) && is_string(key($value)) && substr(key($value), 0, 1) == ':'):

                        $parameters = array_merge($parameters, $value);

                    else:

                        $parameters[] = $value;

                    endif;

                endforeach;

            else:

                if ($clauses):

                    $parameters[] = $clauses;

                endif;

            endif;

        endforeach;

        return $parameters;
    }

    public function getQuery($formated = true) {

        $query = $this->buildQuery();

        if ($formated):

            $query = Utilities::formatQuery($query);

        endif;

        return $query;
    }

    protected function clauseNotEmpty($clause) {

        if (Utilities::isCountable($this->statements[$clause]) && $this->clauses[$clause]):

            return (boolean) count($this->statements[$clause]);

        else:

            return (boolean) $this->statements[$clause];

        endif;
    }
    
    protected function quote($value){
        
        if(!isset($value)):
            
            return "NULL";
            
        endif;
        
        if(is_array($value)):
            
            return sprintf("(%s)", implode(", ", array_map(array($this, 'quote'), $value)));
            
        endif;
        
        $value = $this->formatValue($value);
        
        if(is_float($value)):
            
            return sprintf("%F", $value);
            
        endif;
        
        if($value === FALSE):
            
            return '0';
        
        endif;
        
        if(is_int($value) || $value instanceof Literal):
            
            return (string)$value;
            
        endif;
        
        return $this->init->getPdo()->quote($value);
        
    }

    private function formatValue($value) {

        if ($value instanceof \DateTime):

            return $value->format("Y-m-d H:i:s");

        endif;

        return $value;
    }

    /**
     * Get query parameters
     *
     * @return array
     */
    public function getParameters() {
        return $this->buildParameters();
    }

    protected function getPDO() {

        return $this->init->getPdo();
    }

    protected function getStructure(): Structure {

        return $this->init->getStructure();
    }

    public function getResult() {

        return $this->result;
    }

    public function getTime() {

        return $this->time;
    }

    public function asObject($object = true) {

        $this->object = $object;

        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }



}
