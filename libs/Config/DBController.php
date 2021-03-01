<?php
/**
* Database controller.
* @author Bantayehu Fikadu <bantayehuf@gmail.com>
* @copyright S.R.E Software Development and Network
* 
*There are 3 public functions that accept 2 parameters (query, value)
*'baseQuery()' For basic queries INSERT, UPDATE, and DELETE
*'baseSelect()' To select a single row.
*'multiSelect()' To select multiple rows
*/

namespace Lib\Config;
use Lib\Utils\Logger;
use PDO;
use PDOException;

class DBController {

    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_NAME = 'sre_php_standard';

    private $conn=null;
    private $statement=null;
    //Intialize database connection.
    public function __construct() {
        try{
            $this->conn = $this->connectDB();
        }catch (PDOException $exc) {
            require_once 'database_crush_error.php';
            Logger::Log($exc->getMessage());
            die();
        }
    }   
    //PDO database connection
    private function connectDB() {
        $conn = new PDO("mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME,self::DB_USER, self::DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    //To pass variables to SQL for execution 
    private function bindQueryParams($value) {
        $num = count($value);
        $colCount=1;
        for($i=0 ; $i<$num ; $i++){
            $this->statement->bindParam($colCount , htmlentities(trim($value[$i])) , PDO::PARAM_STR);
            $colCount=$colCount+1;
        }
    }
    //To select a single row.
    public function baseSelect($query, $value) {
        try{
            $this->statement = $this->conn->prepare($query);
            if(!empty($value)){
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            $row=$this->statement->fetch(PDO::FETCH_OBJ);
            return array('Success' , $row);
        }catch (PDOException $exc) {
            return array('Error' , $exc->getMessage());
        }
    } 
    //To select multiple rows
    public function multiSelect($query, $value) {
        try{
            $this->statement = $this->conn->prepare($query);
            if(!empty($value)){
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            $rows=$this->statement->fetchAll(PDO::FETCH_OBJ);
            return array('Success' , $rows);
        }catch (PDOException $exc) {
            return array('Error' , $exc->getMessage());
        }
    }
    //For basic queries INSERT, UPDATE, DELETE
    public function baseQuery($query, $value) {
        try{
            $this->statement = $this->conn->prepare($query);
            if(!empty($value)){
                $this->bindQueryParams($value);
            }
            $this->statement->execute();

            if ($this->statement->rowCount()>0) {
                return array('Success');
            }else{
                return array('Failed','Action has not completed successfully.');
            }
        }catch (PDOException $exc) {
            return array('Error' , $exc->getMessage());
        }
    }
}
?>