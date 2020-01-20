<?php
	require_once 'includes/sessions.php';
	if (mySession_start())
	{
		header("location: lk.php");
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
					
					<div class="auth">
						<form action="" method="post">
 							Логин: <input type="text" name="login" />
 							Пароль: <input type="password" name="password" />
 							<input type="submit" value="Войти" name="log_in" />
						</form>
					</div>

					<?php
						if (isset($_POST['log_in'])) 
						{
							$login = htmlspecialchars( trim($_POST['login']) ); 
							$password = htmlspecialchars( trim($_POST['password']) );
					
							if (!empty($login) && !empty($password))
 							{
 								$sql = 'SELECT acc_id, acc_password FROM restaurant_accounts WHERE acc_email = :login';
 								$params = [':login' => $login];
 								$stmt = $db->prepare($sql);
 								$stmt->execute($params);

 								$user = $stmt->fetch(PDO::FETCH_OBJ);

 								if ($user) 
 								{
 									if ($user->acc_password == md5($password))
 									{
 										mySession_write($user->acc_id);
 										header('Location: lk.php');
 									}
 									else
 										echo "Неверный логин или пароль!"; 
 								}
 								else
 									echo "Пользователь не найден!";
 							}
 							else
 								echo "Неверно задан логин или пароль!"; 
						}
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