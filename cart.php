<?php
	require_once 'includes/db.php';
	require_once 'includes/sessions.php';
	
	if (!mySession_start())
	{
		exit("<br><a href='login.php'>Авторизация</a><br> Необходимо авторизоватсья!");
	}

	if (isset($_GET['action']) && $_GET['action']=="add")
	{
		if (isset($_COOKIE['SESSID'])) 
		{	
			// информация о пицце
			$sql = 'SELECT dish_tittle, dish_price FROM restaurant_dish WHERE dish_tittle = :dish_id';
			$params = [ ':dish_id' => strval(trim($_GET['id'])) ];
			$stmt = $db->prepare($sql);
			$stmt->execute($params);
			$dish = $stmt->fetch(PDO::FETCH_OBJ);

			if ($dish)
			{
				// информация об аккаунте
				$sql_acc = 'SELECT acc_id FROM restaurant_session WHERE session_id = :sess_id';
				$stmt_acc = $db->prepare($sql_acc);
				$stmt_acc->execute([':sess_id' => $_COOKIE['SESSID']]);
				$acc = $stmt_acc->fetch(PDO::FETCH_OBJ);

				// добавление пиццы в корзину

				$get_order = $db->prepare('SELECT * FROM restaurant_cart WHERE session_id = :sess_id AND acc_id = :acc_id AND dish_tittle = :dish_tittle');
			
				$get_order->execute([ ':sess_id' => $_COOKIE['SESSID'], ':acc_id' => $acc->acc_id, ':dish_tittle' => $dish->dish_tittle ]);
				$order = $get_order->fetch(PDO::FETCH_OBJ);

				if ($order)
				{
					// обновляем текущую позицию



					$add_cart_sql = 'UPDATE restaurant_cart SET count = :new_count
									 WHERE acc_id = :acc_id AND dish_tittle = :dish_tittle';

					$add_cart_params = [ 
										 ':new_count' => $order->count + 1, 
										 ':acc_id' => $acc->acc_id, 
										 ':dish_tittle' => $dish->dish_tittle
									   ];
				}
				else
				{
					$add_cart_sql = 'INSERT INTO restaurant_cart (session_id, price, count, dish_tittle, acc_id) 
								 	 VALUES (:sess_id, :price, :count, :dish_tittle, :acc_id)';
					$add_cart_params = [ ':sess_id' => $_COOKIE['SESSID'], 
										 ':price' => $dish->dish_price, 
										 ':count' => 1, 
										 ':dish_tittle' => $dish->dish_tittle, 
										 ':acc_id' => $acc->acc_id
									   ];
				}

				$stmt = $db->prepare($add_cart_sql);
				$stmt->execute($add_cart_params);
			}
		}
	}

	if (isset($_GET['action']) && $_GET['action']=="drop")
	{
		$sql = 'DELETE FROM restaurant_cart WHERE session_id = :sess_id AND dish_tittle = :dish_id';
		$params = [  'sess_id' => $_COOKIE['SESSID'],
				     ':dish_id' => strval(trim($_GET['id'])) 
				  ];
		$stmt = $db->prepare($sql);
		$stmt->execute($params);
	}	


    if (isset($_POST['buy']))
    { 
    	$get_items = 'SELECT * FROM restaurant_cart WHERE session_id = :sess_id';
    	$stmt = $db->prepare($get_items);
    	$stmt->execute([ ':sess_id' => $_COOKIE['SESSID']]);

    	$order = $stmt->fetch(PDO::FETCH_OBJ);

		if ($order)
		{	
			$order_id = uniqid();

			$update_cart = 'UPDATE restaurant_cart SET session_id = :new_sess_id, order_id = :order_id WHERE session_id = :sess_id';
			$stmt = $db->prepare($update_cart);
			$stmt->execute([':new_sess_id' => NULL, ':sess_id' => $_COOKIE['SESSID'], ':order_id' => $order_id]);

			$add_order = 'INSERT INTO restaurant_orders (order_id, order_status, user_id) 
						  SELECT
						  		:order_id AS order_id,
						  		"Обработка заказа" AS order_status,
						  		restaurant_accounts.user_id AS user_id
						  FROM restaurant_cart
						  INNER JOIN restaurant_accounts
						  ON restaurant_accounts.acc_id = restaurant_cart.acc_id 
						  LIMIT 1
						 ';
			$stmt = $db->prepare($add_order);
			$stmt->execute([':order_id' => $order_id]);

		}

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

					<h1>Корзина</h1> 
					<form method="post" action="cart.php?page=cart"> 
						<table> 
          					<tr> 
            					<th>Название</th> 
            					<th>Количество</th> 
            					<th>Цена</th> 
            					<th>Сумма</th> 
        					</tr> 

        					<?php 

								$sql = 'SELECT * FROM restaurant_cart WHERE session_id = :sess_id';
        						$stmt = $db->prepare($sql);
        						$stmt->execute([ ':sess_id' => $_COOKIE['SESSID'] ]);

        						$products = '';
        						$counts = 0;
        						$totalprice = 0; 

       
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
								{
									$totalprice += $row['price'] * $row['count'];
							?>
								<tr> 
        							<td><?php echo $row['dish_tittle'] ?></td> 
        						    <td><?php echo $row['count'] ?></td>
        							<td><?php echo $row['price'] ?> ₽</td> 
        							<td><?php echo $row['price'] * $row['count'] ?> ₽</td> 
        							<td> <a class="button" 
        								    href="cart.php?page=cart&action=drop&id=<?php echo $row['dish_tittle'] ?>">
        									Убрать
        								 </a>  
        							</td>
        						</tr>

        						<?php } ?>

        					<tr> 
                       	 		<td colspan="4">К оплате: <?php echo $totalprice  ?> ₽</td> 
                    		</tr> 

                    		<button type="submit" name="buy">Оформить заказ</button> 
   
        				</table>
					</form>

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