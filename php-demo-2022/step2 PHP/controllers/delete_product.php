<?php
	include "check_admin.php";
	include "../connect.php";
	$connect->query("DELETE `products`, `orders` FROM `products` RIGHT JOIN `orders` USING(`product_id`) WHERE `product_id`=".$_GET["id"]);
	return header("Location:../admin?message=Товар удалён");