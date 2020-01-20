<?php
	require_once 'includes/sessions.php';

	if (!mySession_start())
	{
		header("location: login.php");
	}

	/* ПРОВЕРКА НА АДМИНА [НАЧАЛО] */
	$sql = 'SELECT * FROM restaurant_users 
			INNER JOIN restaurant_accounts ON restaurant_accounts.user_id = restaurant_users.u_id 
			INNER JOIN restaurant_session ON restaurant_session.acc_id = restaurant_accounts.acc_id 
			INNER JOIN restaurant_availability ON restaurant_availability.acc_id = restaurant_accounts.acc_id
			WHERE restaurant_session.session_id = :sess_id';

	$stmt = $db->prepare($sql);
 	$stmt->execute([':sess_id' => $_COOKIE['SESSID']]);
 	$user = $stmt->fetch(PDO::FETCH_OBJ);

	if ($user->u_role != 'admin')
 	{
 		header("location: lk.php");
 	}
 	/* ПРОВЕРКА НА АДМИНА [КОНЕЦ] */

	if (isset($_GET['action']) && $_GET['action']=="drop")
	{ 
		$sql = 'DELETE FROM restaurant_orders WHERE order_id = :order_id';
		$params = [ ':order_id' => strval(trim($_GET['id'])) ];
		$stmt = $db->prepare($sql);
		$stmt->execute($params);
	}

	if (isset($_GET['action']) && $_GET['action']=="update")
	{
		$sql = 'UPDATE restaurant_orders SET order_status = "Доставляется" WHERE order_id = :order_id';
		$params = [ ':order_id' => strval(trim($_GET['id'])) ];
		$stmt = $db->prepare($sql);
		$stmt->execute($params);
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
					<h1>Список заказов</h1> 
					<table> 
          					<tr> 
            					<th>Идентификатор</th> 
            					<th>Наименования</th> 
            					<th>Количество</th> 
            					<th>Статус</th> 
            					<th>Сумма</th> 
        					</tr>

							<?php
								$sql = 'SELECT * FROM restaurant_orders
										INNER JOIN restaurant_cart ON restaurant_cart.order_id = restaurant_orders.order_id
									   ';

								$stmt = $db->query($sql);

								$totalorder = array('id' => 0, 'price' => 0, 'status' => '');

								while ($order = $stmt->fetch(PDO::FETCH_OBJ)) 
								{
							?>		
									<tr>
										<td> 
											<?php echo $order->order_id; ?>  
										</td>

										<td>	
											<?php echo $order->dish_tittle ?>
										</td>

										<td>
											<?php echo $order->count ?>
										</td>

										<td>
											<?php 
												$totalorder['status'] = $order->order_status;
												echo $order->order_status;
											?>
										</td>



										<td>
											<?php
										        $totalorder['price'] = $order->price * $order->count;
												echo $totalorder['price'].' ₽';
											?>
										</td>

										<td>
											<?php 
												if ($totalorder['id'] != $order->order_id) 
												{
													$totalorder['status'] = '';
													$totalorder['id'] = $order->order_id;
											?>
											

													<a 	class="button" 
													   	href="orders.php?page=orders&action=drop&id=<?php echo  $totalorder['id'] ?>" >
        												Отмена заказа
        											</a> 

        											<a 	class="button" 
        												href="orders.php?page=orders&action=update&id=<?php echo  $totalorder['id'] ?>" >
        												Изменить статус заказа
        											</a> 
        								
										  <?php } ?>
										
										</td>
									</tr>
						  <?php } ?>
		
        			</table>
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