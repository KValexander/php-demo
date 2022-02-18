<?php
	session_start();
	include "connect.php";
	
	$role = (isset($_SESSION["role"])) ? $_SESSION["role"] : "guest";
	$id = (isset($_GET["id"])) ? $_GET["id"] : 0;

	$sql = "SELECT * FROM `products` WHERE `count` > 0 AND `product_id`=". $id;
	if(!$result = $connect->query($sql))
		return die ("Ошибка получения данных: ". $connect->error);

	if(!$product = $result->fetch_assoc())
		return header("Location:index.php?message=Товар отсутствует");

	include "header.php";
?>

	<main>
		<div class="content">
			
			<div class="head"><?= $product["name"] ?></div>
			<div class="product wrap">
				<div class="image">
					<img src="<?= $product["path"] ?>" alt="">
				</div>
				<div class="text">
					<h3>Характеристики:</h3>
					<p>Страна: <b><?= $product["country"] ?></b></p>
					<p>Год выпуска: <b><?= $product["year"] ?></b></p>
					<p>Модель: <b><?= $product["model"] ?></b></p>
					<hr>
					<div class="row">
						<p>Цена:</p>
						<h3><?= $product["price"] ?>$</h3>
					</div>
					<?php
						if($role == "admin")
							echo '
								<div class="row">
									<p><a href="update.php?id='.$product["product_id"].'" class="text-small">Редактировать</a></p>
									<p><a onclick="return confirm(\'Вы действительно хотите удалить этот товар?\')" href="controllers/delete_product.php?id='.$product["product_id"].'" class="text-small">Удалить</a></p>
								</div>
							';

						if($role != "guest")
							echo '<p class="text-right"><a href="controllers/add_cart.php?id='. $product["product_id"] .'" class="text-small">В корзину</a></p>';
					?>
				</div>
			</div>

		</div>
	</main>

<?php include "footer.php" ?>