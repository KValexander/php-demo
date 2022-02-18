<?php
	include "controllers/check.php";

	include "connect.php";

	$sql = sprintf("SELECT `order_id`, `product_id`, `orders`.`count`, `name`, `price`, `path` FROM `orders` INNER JOIN `products` USING(`product_id`) WHERE `user_id`='%s'", $_SESSION["user_id"]);
	$result = $connect->query($sql);

	$products = "";
	while($row = $result->fetch_assoc())
		$products .= sprintf('
			<div class="col">
				<img src="%s" alt="">
				<div class="row">
					<h3><a href="product.php?id=%s">%s</a></h3>
					<p>%s$</p>
				</div>
				<div class="row">
					<p><a href="controllers/delete_cart.php?id=%s">Убрать</a></p>
					<p id="c1">%s</p>
					<p><a href="controllers/add_cart.php?id=%s">Добавить</a></p>
				</div>
			</div>
		', $row["path"], $row["product_id"], $row["name"], $row["price"], $row["product_id"], $row["count"], $row["product_id"]);

	if($products == "")
		$products = '<h3 class="text-center">Корзина пуста</h3>';

	$sql = sprintf("SELECT * FROM `orders` WHERE `user_id`='%s' AND `number` IS NOT NULL AND `product_id`=0 ORDER BY `created_at` DESC", $_SESSION["user_id"]);
	$result = $connect->query($sql);

	$orders = "";
	while($row = $result->fetch_assoc()) {
		$del = ($row["status"] == "Новый") ? '<p class="text-right"><a onclick="return confirm(\'Вы действительно хотите удалить этот заказ?\')" href="controllers/delete_order.php?id='.$row["order_id"].'" class="text-small">Удалить заказ</a></p>' : '';
		$orders .= sprintf('
			<div class="col">
				<div class="row">
					<h2>Заказ %s</h2>
					%s
				</div>
				<div class="row">
					<p>Статус: <b>%s</b></p>
					<p>Количество товаров: <b>%s</b></p>
				</div>
			</div>
		', $row["number"], $del, $row["status"], $row["count"]);
	}

	if($orders == "")
		$orders = '<h3 class="text-center">Список заказов пуст</h3>';

	include "header.php";
?>

	<main>
		<div class="content">

			<div class="head">Ваша корзина</div>
			<div class="row">
				<?= $products ?>
			</div>
			<br>
			<div class="wrap">
				<form action="controllers/checkout.php" class="w100" method="POST">
					<input type="password" placeholder="Ваш пароль" name="password" required>
					<button>Сформировать заказ</button>
				</form>
			</div>

			<div class="head">Ваши заказы</div>
			<div class="row">
				<?= $orders ?>
			</div>

		</div>
	</main>

<?php include "footer.php" ?>