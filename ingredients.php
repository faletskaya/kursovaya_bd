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
						<a href="favorite.php">Фавориты недели</a>
						<a href="dish.php">Блюда</a>
						<a href="ingredients.php">Состав блюд</a>		
					</div>
				</div>
			</div>
			<!-- КОНТЕНТ -->
			<div class="content">
				<div class="wrapper">

						<?php 

							$sql = 'SELECT * FROM restaurant_ingredients WHERE dish_tittle = :dish_tittle';
							$stmt = $db->prepare($sql);

							$dish = $db->query("SELECT * FROM restaurant_dish");

							foreach ($dish as $tittle)
							{	
								$stmt->execute([':dish_tittle' => $tittle['dish_tittle'] ]);
								$ingredients = '';

    							while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
								{	
									$ingredients = $ingredients.', '.$row['ingredient'];
								}

								$ingredients = ltrim($ingredients, ",");

								echo '<div class="ramen-item">
									  	<img src="'.$tittle['dish_img'].'">
									  	<div class="product-composition">
									  		<h3>'.$tittle['dish_tittle'].'</h3>
									  		<b>'.$ingredients.'</b>
									  	</div>
									  </div>';

							}

							$sql = null;
							$stmt = null;
							$dish = null;
						?>

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