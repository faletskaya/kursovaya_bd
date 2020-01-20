<?php
	require_once 'includes/sessions.php';

	if (!mySession_start())
	{
		header("location: login.php");
	}

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
						<a href="logout.php">Выйти</a>
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

					<b>Добро пожаловать!</b>

					<?php 

						$sql = 'SELECT * FROM restaurant_users 
								INNER JOIN restaurant_accounts ON restaurant_accounts.user_id = restaurant_users.u_id 
								INNER JOIN restaurant_session ON restaurant_session.acc_id = restaurant_accounts.acc_id 
								INNER JOIN restaurant_availability ON restaurant_availability.acc_id = restaurant_accounts.acc_id
								WHERE restaurant_session.session_id = :sess_id';
						$stmt = $db->prepare($sql);
 						$stmt->execute([':sess_id' => $_COOKIE['SESSID']]);
 						$user = $stmt->fetch(PDO::FETCH_OBJ);

 						echo '<br>Здравсвуйте,<u>'.$user->u_name.'</u>Вы вошли на сайт Ramen laboratory. 
 							  <br>На вашем счету '.$user->amount.' ₽
 							 ';

 						if ($user->u_role == 'admin')
 						{

 							echo "<br><br>Меню:
 							  <br><a href='orders.php'> Заказы</a>
 							";
 						
 						}
 		
					?>
	
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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