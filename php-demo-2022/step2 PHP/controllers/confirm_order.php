<?php
	include "check_admin.php";
	include "../connect.php";

	$connect->query("UPDATE `orders` SET `status`='Подтверждённый' WHERE `order_id`=".$_POST["id"]);
	return header("Location:../admin?message=Статус заказа изменёна на \"Подтверждённый\"");
