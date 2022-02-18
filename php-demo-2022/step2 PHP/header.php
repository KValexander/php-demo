<?php
	$menu = '
		<li><a href="index.php">О нас</a></li>
		<li><a href="catalog.php">Каталог</a></li>
		<li><a href="where.php">Гда нас найти?</a></li>
		%s
	';

	$m = '';
	if(isset($_SESSION["role"])) {
		$m = '<li><a href="cart.php">Корзина</a></li>';
		$m .= ($_SESSION["role"] == "admin") ? '<li><a href="admin">Заказы</a></li>' : '';
		$m .= '<li><a href="controllers/logout.php">Выход</a></li>';
	} else
		$m = '
			<li><a href="index.php#login"><button>Вход</button></a></li>
			<li><a href="index.php#register"><button>Регистрация</button></a></li>
		';

	$menu = sprintf($menu, $m);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Интернет-магазин</title>
	<link rel="stylesheet" href="style.css">
	<script src="scripts/filter.js"></script>
	<script>
		let role = "<?= (isset($_SESSION["role"])) ? $_SESSION["role"] : "guest" ?>";
	</script>
</head>
<body>

	<header>
		<div class="top">
			<div class="row">
				<img src="logo/logo.png" alt="">
				<a href="index.php">
					<h1>Copy Star</h1>
				</a>
			</div>
			<h2>Девиз компании!</h2>
		</div>
		<div class="content">
			<ul>
				<?= $menu ?>
			</ul>
		</div>
	</header>

	<div class="message"><?= (isset($_GET["message"])) ? $_GET["message"] : ""; ?></div>