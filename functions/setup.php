<?php

require_once '../core/init.php';

	$pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	if (!$pdo) {
		echo "could not connect";
	}

	$sql = 'CREATE DATABASE IF NOT EXISTS ' . $db;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$sql = 'USE ' . $db;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = 'CREATE TABLE IF NOT EXISTS users (
		id INT AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(50) NOT NULL,
		email VARCHAR(100) NOT NULL,
		`group` INT NOT NULL,
		`password` VARCHAR(64) NOT NULL,
		salt VARCHAR(350) NOT NULL,
		emailconfirm TINYINT DEFAULT 0,
		notify	TINYINT DEFAULT 0,
		joined DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = "SELECT count(*) FROM `users` WHERE BINARY username = 'Admin'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$number_of_rows = $stmt->fetchColumn();
	if(!$number_of_rows) {
		$sql = 'INSERT INTO users(`username`, `email`, `group`, `emailconfirm`, `notify`, `password`, `salt`)
		VALUES ("Admin", "bnkosi@student.wethinkcode.co.za", 2, 1, 1, "' . $hash . '", "' . $s_hash . '")';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	}
	$sql = 'CREATE TABLE IF NOT EXISTS `groups` (
		id INT AUTO_INCREMENT PRIMARY KEY,
		group VARCHAR(50) NOT NULL,
		permissions TEXT)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();



	$sql = "SELECT count(*) FROM `groups` WHERE group = 'Standard user'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$number_of_rows = $stmt->fetchColumn();
	if(!$number_of_rows) {
		$sql = 'INSERT INTO `groups`(`group`) VALUES ("Standard user")';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	}

	$sql = "SELECT count(*) FROM `groups` WHERE group = 'Administrator'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$number_of_rows = $stmt->fetchColumn();
	if(!$number_of_rows) {
		$sql = 'INSERT INTO `groups`(`group`, `permissions`) VALUES ("Administrator", \'{\r\n\"admin\": 1,\r\n\"mod\": 1\r\n}\')';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	}

	$sql = 'CREATE TABLE IF NOT EXISTS user_session (
		id INT AUTO_INCREMENT PRIMARY KEY,
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
	$stmt->execute();
?>