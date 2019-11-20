<?php
	require_once 'database.php';

	$sql = "CREATE DATABASE IF NOT EXISTS " . $db;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$sql = 'USE ' . $db;
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "Database created<br>";
    } else {
        echo "nothing, zip zero";
	}

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
	if ($stmt->execute()) {
		echo "users created<br>";
    } else {
        echo "nothing, zip zero";
	}

	$sql = 'CREATE TABLE IF NOT EXISTS `groups` (
		`id` INT AUTO_INCREMENT PRIMARY KEY,
		`permissions` TEXT,
		`group` VARCHAR(50) NOT NULL)';
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "groups created<br>";
    } else {
        echo "nothing, zip zero";
	}

	$sql = 'CREATE TABLE IF NOT EXISTS users_session (
		id INT AUTO_INCREMENT PRIMARY KEY,
		`user_id` INT,
		`hash` VARCHAR(150) NOT NULL)';
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "Users_session created <br>";
    } else {
        echo "nothing, zip zero";
	}

	$sql = 'CREATE TABLE IF NOT EXISTS images (
		id INT AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(250) NOT NULL,
		imgaddress VARCHAR(130) NOT NULL,
		imagename VARCHAR(64) NOT NULL,
		postdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "images created<br>";
    } else {
        echo "nothing, zip zero";
	}

	$sql = 'CREATE TABLE IF NOT EXISTS comments (
		id INT AUTO_INCREMENT PRIMARY KEY,
		imageid INT NOT NULL,
		comment LONGBLOB NOT NULL,
		userid VARCHAR(64) NOT NULL,
		postdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "Comments created<br>";
    } else {
        echo "nothing, zip zero";
	}

	$sql = 'CREATE TABLE IF NOT EXISTS likes (
		id INT AUTO_INCREMENT PRIMARY KEY,
		imageid INT NOT NULL,
		username VARCHAR(130) NOT NULL,
		likerid VARCHAR(64) NOT NULL,
		postdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		echo "likes created<br>";
    } else {
        echo "nothing, zip zero";
	}
?>