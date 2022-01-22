<?php
$connect = new mysqli("localhost", "root", "root", "db_demo_template");
$connect->set_charset("utf-8");
if($connect->connect_error)
	die("Connection error: ". $connect->connect_error);