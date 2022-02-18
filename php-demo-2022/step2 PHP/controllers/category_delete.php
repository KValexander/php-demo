<?php
	include "check_admin.php";
	include "../connect.php";

	$connect->query("DELETE FROM `categories` WHERE `category`=".$_POST["category"]);

	return header("Location:../admin?message=Категория удалена");