<?php
    require_once '../core/init.php';
    
    if (Session::exists('home')) {
        echo '<p>' . Session::flash('home') . '</p>';
    }

    $user = new User();
    if($user->isLoggedin()) {
?>    
    <p>Hello <a href='profile.php?user=<?php echo escape($user->data()->username); ?>'><?php echo escape($user->data()->username); ?></a>!</p>
    <ul>
        <li><a href="logout.php">Log out</a></li>
    </ul>
<?php
    // if($user->hasPermission('admin')) {
    //     echo '<p>You are an administrator</p>';
    // }
    
    } else {
        echo '<p> You need to <a href="login.php">log in</a> or <a href="register.php">register</a>, peasant </p>';
    } 
?>

<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>Document</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        
    </body>
</html>