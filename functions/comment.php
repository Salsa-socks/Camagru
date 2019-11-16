<?php
    require_once "../core/init.php";
    if ($_SESSION['user'])
    {
        try {
            $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "failed to connect to server";
        }
        echo $_SESSION['user'] . " " . $_POST['id'] . " " . $_POST['comment'];
        $stmt = "INSERT INTO `comments` (`imageid`, `userid`, `comment`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($stmt);
        $stmt->execute(array($_POST['id'], $_SESSION['user'], $_POST['comment']));
    }
    else
        http_response_code(400);

?>