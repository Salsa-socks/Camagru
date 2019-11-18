<?php
    require_once '../core/init.php';

	$pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql =  'DROP DATABASE IF EXISTS' . $db;
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute()) {
        echo "Table Deleted";
    } else {
        print_r($sql->errorInfo());
    }
?>