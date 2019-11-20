<?php
    $host = "localhost";
	$username = "root";
	$password = "Ocvm53ujido";
	$db = "camlog";
	$pdo = new PDO("mysql:host=$host;", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (!$pdo) {
		echo "could not connect";
	}
?>