<?php
	$connect = new mysqli("localhost", "root", "root", "db_demo_2022");
	$connect->set_charset("utf8");

	if($connect->connect_error)
		die("Ошибка подключения: ". $connect->connect_error);
