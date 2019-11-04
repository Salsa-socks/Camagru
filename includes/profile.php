<?php
    require_once '../core/init.php';

        $username = Input::get('user');
        $user = new User($username);
        if (!$user->exists()) {
            Redirect::to(404);
        } else {
            $data = $user->data();
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
        <header>
            <a href= "index.php"><i class="fas fa-home"></i></a>
            <a href= "search.php"><i class="fas fa-search"></i></a>
            <a href= "likes.php"><i class="fas fa-heart"></i></a>
            <a href= "update.php"><i class="fas fa-user-circle"></i></a>
            <button id="myBtn" style="color: white; border: none; cursor: pointer; background: none; width: 0;
margin: 0; margin-left: 4%"><i class="fas fa-camera-retro"></i></button>
        </header>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Hi, take a pic and upload it!</h2>
                <p>Make sure you click allow to ue your cam, when you're 
                    done taking your pic, add a filter and upload it </p>
                <div class="booth">
                    <video id="video" width="100%"></video>
                    <a href ="#" id="capture" class="capturebtn">Take Photo</a>
                    <canvas id="canvas" width="500" height="500" ></canvas>
                    <a href ="#" id="upload" class="uploadbtn">Upload</a>
                </div>
            </div>
        </div> 
        <div class="content">
            <div class="frame">
                <div class="profile">
                    <div class="circle"></div>
                        <div class="user-d">
                        <div class="usern"><h3 style="font-size: 2.5vh"><?php echo escape($data->username); ?></h3></div>
                        <div class="unamed"><h2 style="text-align: left;font-size: 3vh;"><?php echo escape($data->name); ?> </h2></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="./js/modal.js"></script>
        <script src="./js/cam.js"></script>
    </body>
</html>
