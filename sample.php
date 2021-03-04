<?php
/*
*Sample codes how to use Database controller
*/

//including DBController (Database Controller) class as Database
use Lib\Config\DBController as Database;

//Instantiate db_handler object from database class
$db_handler = new Database;

//insert into the table
$query = <<<SQL
   INSERT INTO sample_table SET id=?,name=?
SQL;
$value=array($id,$name);
$response=$db_handler->baseQuery($query, $value);
if ($response[0]=='Success') {
	echo "Inserted";
}

//update
$query = <<<SQL
   UPDATE sample_table SET name=? WHERE id=?
SQL;
$value=array($name,$id);
$response=$db_handler->baseQuery($query, $value);
if ($response[0]=='Success') {
	echo "Updated";
}

//delete a single row
$query = <<<SQL
   DELETE FROM sample_table WHERE id=?
SQL;
$value=array($id);
$response=$db_handler->baseQuery($query, $value);
if ($response[0]=='Success') {
	echo "A row from the table is deleted";
}

//delete all rows from the table
$query = <<<SQL
   DELETE FROM sample_table
SQL;
$value=array();//empty array indicates no values will pass with the query
$response=$db_handler->baseQuery($query, $value);
if ($response[0]=='Success') {
	echo "All rows from the table is deleted";
}

//select (Retrive) a single row
$query = <<<SQL
   SELECT name FROM sample_table WHERE id=?
SQL;
$value=array($id);
$row = $db_handler->baseSelect($query, $value);//baseSelect is used to select a single row

//check for a row fetched without error
if ($row[0]!='Error') {
   //Display row
}else{
   //Display error message
}


//Retrive (select) multiple rows
$query = <<<SQL
   SELECT * FROM sample_table
SQL;
$value=array();//empty array indicates no values will pass with the query
$rows = $db_handler->multiSelect($query, $value);//multiSelect is used to select multiple rows

//check for a row fetched without error
if ($row[0]!='Error') {
   foreach($rows as $row){
      //Display rows
   }
}else{
   //Display error message
}


?>