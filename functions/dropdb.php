<?php
    require_once '../core/init.php';

	$host = "localhost";
	$username = "root";
	$password = "Ocvm53ujido";
	$db = "camlog";
	$pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'DROP DATABASE IF EXISTS ' . $db;
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute()) {
        echo "Database Deleted";
    } else {
        print_r($sql->errorInfo());
    }
?>