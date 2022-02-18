<?php
	include "check.php";
	include "../connect.php";

	$id = $_GET["id"];

	$sql = "SELECT * FROM `products` WHERE `product_id`=".$id;
	$product = $connect->query($sql)->fetch_assoc();

	if($product["count"] <= 0)
		return header("Location:../cart.php?message=Товар отсутствует");

	$sql = sprintf("SELECT * FROM `orders` WHERE `user_id`='%s' AND `product_id`='%s'",$_SESSION["user_id"], $id);
	if($order = $connect->query($sql)->fetch_assoc())
		$connect->query(sprintf("UPDATE `orders` SET `count`='%s' WHERE `order_id`='%s'", ++$order["count"], $order["order_id"]));
	else
		$connect->query(sprintf("INSERT INTO `orders`(`product_id`, `user_id`, `count`) VALUES('%s', '%s', '%s')", $product["product_id"], $_SESSION["user_id"], 1));

	$connect->query(sprintf("UPDATE `products` SET `count`='%s' WHERE `product_id`='%s'", --$product["count"], $product["product_id"]));

	return header("Location:../cart.php?message=Товар добавлен в корзину");
