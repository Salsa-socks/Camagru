<?php
    require_once '../core/init.php';

    // if(isset($_GET['salt'])) {
        // $con = DB::getInstance();
        $conn = new User();
        $user = new User(Input::get('user'));
        $check = $user->data()->id;
        $saltcheck = $_GET['salt'];
        if ($saltcheck)
        {
            echo "hello user is there";
        }
        if ($check) {

            try {
                $update = "UPDATE users SET emailconfirm = 1 WHERE id=$check";
                // Redirect::to('login.php');

            } catch(Exception $e) {
                die($e->getMessage());
            }
        }else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
        
    // } else {
    //     die ("Something went wrong validating your account, please register again, sorry, peasant..");
    // }


    // //////////////////////////////////////////////////////////////////
    // $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // $update = "UPDATE users SET emailconfirm = 1 WHERE id=33";

    // $stmt = $conn->prepare($update);
    // $stmt->execute();

    // echo $stmt->data()->id;

?>


<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>Verification</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body style="background-image: url(./img/back2.png)">
        <div class="landinginfo">
            <div class="style fade-in">
                <img src="./img/logo.png" style="width:7%";>
                <p style="background: white;width: 45%;margin: 0 auto; font-size: 3vh">Please click the button below to verify your account</p>
            </div>
        </div>
    </body>
</html>