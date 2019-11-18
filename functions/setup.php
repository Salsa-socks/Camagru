<?php

// require_once '../core/init.php';

	$host = "localhost";
	$username = "root";
	$password = "Ocvm53ujido";
	$db = "camlog";
	$pdo = new PDO("mysql:host=$host;", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (!$pdo) {
		echo "could not connect";
	}

	$sql = "CREATE DATABASE IF NOT EXISTS " . $db;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$sql = 'USE ' . $db;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS users (
		id INT AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(50) NOT NULL,
		`name` VARCHAR(50) NOT NULL,
		email VARCHAR(100) NOT NULL,
		`group` INT NOT NULL,
		`password` VARCHAR(64) NOT NULL,
		salt VARCHAR(350) NOT NULL,
		emailconfirm TINYINT DEFAULT 0,
		notify	TINYINT DEFAULT 0,
		joined DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS `groups` (
		`id` INT AUTO_INCREMENT PRIMARY KEY,
		`group` VARCHAR(50) NOT NULL)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS users_session (
		`user_id` INT AUTO_INCREMENT PRIMARY KEY,
		`session` INT NOT NULL,
		hash VARCHAR(64) NOT NULL)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS images (
		id INT AUTO_INCREMENT PRIMARY KEY,
		username INT NOT NULL,
		imgaddress VARCHAR(130) NOT NULL,
		imagename VARCHAR(64) NOT NULL,
		postdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS comments (
		id INT AUTO_INCREMENT PRIMARY KEY,
		imageid INT NOT NULL,
		comment VARCHAR(130) NOT NULL,
		userid VARCHAR(64) NOT NULL,
		postdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS likes (
		id INT AUTO_INCREMENT PRIMARY KEY,
		imageid INT NOT NULL,
		username VARCHAR(130) NOT NULL,
		likerid VARCHAR(64) NOT NULL,
		postdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "Database created";
    } else {
        echo "nothing, zip zero";
	}
?>