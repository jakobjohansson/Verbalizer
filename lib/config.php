<?php
/********************************************
* VB
* Config file
* Copyright (c) 2016 Jakob Johansson
*********************************************/

// set some universal settings
session_start();
error_reporting(E_ALL);

if (file_exists(dirname(__FILE__).'/define.php')) {
	include(dirname(__FILE__).'/define.php');
}
// check if SQL works, otherwise redirect to install
if (!defined("DB_HOST") || !defined("DB_USER") || !defined("DB_PASS") || !defined("DB_DATABASE") || !defined("DB_INSTALLED")) header("Location: lib/install.php");

// set up database
try {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
} catch (Exception $e) {
	echo $e->getMessage();
}

// autoload
function __autoload($class) {
	require(dirname(__FILE__).'/'.$class.'.php');
}

// load functions from a seperate file
require(dirname(__FILE__).'/functions.php');

// load user
$user = new User();

// set up feed 
$feed = Post::getFeed();
$user = new User();

// set up id
$id = $_GET['id'] ?? null;
$post = $id ? new Post($id) : false;

//good to go
?>