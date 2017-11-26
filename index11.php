<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('DATABASE', 'sm2555');
define('USERNAME', 'sm2555');
define('PASSWORD', 'tzw8bjLL');
define('CONNECTION', 'sql1.njit.edu');

include 'model.php';
include 'database.php';
include 'collection.php';
include "account.php";
include "todos.php";
include "todo.php";
include 'accounts.php';
include "htmlTable.php";

echo "<h1><u> This is PHP ActiveRecord Assignment </u></h1>";
$obj = new Account;
$obj->save();
$obj =  accounts::create();
$result = $obj -> findAll();
htmlTable::createTable($result);
?>