<?php
	include "check_admin.php";
	include "../connect.php";
	$connect->query("DELETE `products` FROM `products` WHERE `product_id`=".$_GET["id"]);
	return header("Location:../admin?message=Товар удалён");