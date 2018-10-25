<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 00:44
 */

namespace Flexe\Db;


trait ConnectTrait
{

    public function connect(){

        $pdo = new \PDO(sprintf("%s:dbname=%s;host=%s", config('db.driver'), config('db.dbname'), config('db.host')), config('db.user'),  config('db.password'));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_LOWER);
        $pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        return $pdo;
    }

}