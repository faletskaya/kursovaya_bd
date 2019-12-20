<?php

	$host = 'localhost';
	$db_name = 'project';
	$db_user = 'admin';
	$db_pass = '1v2f3i4f567890';

	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

	try {
		$db = new PDO("mysql:host=$host;port=3308;dbname=$db_name;charset=utf8", $db_user, $db_pass, $options);
	} catch (PDOException $e) {
		echo 'Подключение не удалось: ' . $e->getMessage();
	}
	
?>
