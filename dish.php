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
					<table class="catalog-list">
						
						<?php 
							$result = $db->query("SELECT * FROM `restaurant_dish`");
							$items = '';
							$count = $result->rowCount();
							$price = '';
							$img = '';
							
							while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
								$items = $items.', '.$row['dish_tittle'];
								$price = $price.' '.$row['dish_price'];
								$img = $img.' '.$row['dish_img'];
							}

							echo '<script type="text/javascript"> 
								  	dishes_tbl("'.$count.'", "'.$items.'", "'.$price.'", "'.$img.'"); 
								  </script>';  

							$result = null;
						?>

					</table>
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
