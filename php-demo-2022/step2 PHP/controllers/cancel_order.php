<?php
	include "check_admin.php";
	include "../connect.php";

	$connect->query(sprintf("UPDATE `orders` SET `status`='Отменённый',`reason`='%s' WHERE `order_id`='%s'", $_POST["reason"], $_POST["id"]));
	return header("Location:../admin?message=Статус заказа изменёна на \"Отменённый\"");
