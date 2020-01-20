<?php
	require_once 'includes/db.php';
	require_once 'includes/sessions.php';
?>

<!DOCTYPE HTML>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Заказать рамен онлайн на дом и в офис. От кафе Ramen laboratory.</title>
		<link rel="shortcut icon" href="img/ico2.png">
		<link rel="stylesheet" href="css/ramen.css" >
		<script src="js/item.js" language="javascript"></script>
	</head>

	<body>

		<div class="cn">

			<!-- Навигация -->
			<div class="navigation">
				<div class="wrapper">
					<div class="menu">
						<a href="index.php">Главная</a>
						<a href="cart.php">Корзина</a>

						<?php
							if (mySession_start())
								echo '<a href="lk.php">Личный кабинет</a>';
							else
								echo '<a href="login.php">Войти</a>';
						?>
						
					</div>
				</div>
			</div>
			<div class="navigation">
				<div class="wrapper">
					<div class="menu">
						<a href="dish.php">Блюда</a>
						<a href="ingredients.php">Состав блюд</a>		
					</div>
				</div>
			</div>

			<!-- КОНТЕНТ -->
			<div class="content">
				<div class="wrapper">
					<img src="img/k1.jpg" alt="img" width="40%" align="left" hspace="10" vspace="10"> 
					<br>
						<b><big>Новый формат для Йошкар-Олы, объединяющий в себе форматы лапшичной и изакая, то есть гастробара. В Японии в такие заведения ходят после работы.
						В центре внимания открытая кухня. Много натурального дерева, света, минималистичный интерьер передающий японский сдержанный стиль.
						Лапше отводится одна из главных ролей в меню, готовят ее на специальной японской noodle-машине, а за аутентичность рецептуры отвечает концепт-шеф Чизуко Сирахама.</big></b>	
					<br><br><br>
						<b><big>Основу меню составляют несколько видов традиционного японского супа рамен и закуски в формате изакая. За гастрономическую концепцию отвечают концепт-шеф Чизуко Сирахама — коренная японка, жена Дениса Иванова. На данный момент в ку можно попробовать 10 разновидностей рамена. Лапшу для блюд рамен готовят на аппарате, специально привезённом из Токио.
						Формат изакая, то есть гастробара, предполагает много маленьких закусок,причем помимо японской классики, здесь как раз допустим и даже приветствуется фьюжн.</big></b>
				</div>
			</div>

			<!-- ПОДВАЛ -->
			<div class="footer">
				<div class="wrapper">
					<img src="img/logo.png" alt="img" width="7%" align="left" hspace="10" vspace="10">
					<br>
					<div class="head">
						<div class="copyright">
					 		<b>Ramen laboratory <span>&copy; 2019 </span></b>
							<span>Бесплатная доставка рамена на дом и в офис.</span>
						</div>	
						<br>
						<div class="phone">
							<b>8 987 654 32 10</b>
							<span>Звонок бесплатный</span>
						</div>
					</div>

				</div>
			</div>
		</div>

	</body>
</html>