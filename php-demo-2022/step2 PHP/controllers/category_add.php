<?php
	include "check_admin.php";
	include "../connect.php";

	$connect->query("INSERT INTO `categories`(`category`) VALUES('".$_POST["category"]."')");

	return header("Location:../admin?message=Категория добавлена");