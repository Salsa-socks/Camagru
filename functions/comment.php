<?php
    require_once "../core/init.php";
    if ($_SESSION['user']){
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

        $db = DB::getInstance();
        $username = Input::get('username');
        $email = ($db->get_property('email','users', array('username', '=', $username)))[0]->email;
        $imageid = Input::get('id');

        if (($db->get_property('notify', 'users', array('username', '=', $username)))[0]->notify) {
            $subject = 'Congrats,Someone commented on your post';
            $message = 'Your picture received a comment.';
            $message .= "\r\n";
            $message .= $_POST['comment'];
            $headers = 'From:noreply@camagru.co.bnkosi' . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
            mail($email, $subject, $message, $headers);
        }
    }
    else
        http_response_code(400);
    

?>