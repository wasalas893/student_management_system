<?php

$dbhost='localhost';
$dbuser='root';
$dbpass='';
$dbname='sunanda1';

$connection=mysqli_connect('localhost','root','','sunanda1');

if(mysqli_connect_errno()){
	die('database connection faild'.mysqli_connect_errno());
}

  ?>
