<?php
    require_once '../core/init.php';

        $username = Input::get('user');
        $user = new User($username);
        try {
            $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "connected";
        } catch(PDOException $e) {
            echo "failed to connect";
        }
        $sql = "SELECT * FROM `images` ORDER BY `images`.`postdate` DESC";
        $res = $conn->prepare($sql);
        $res->execute();

        if (!$user->exists()) {
            Redirect::to('./errors/404.php');
            // Session::flash('404','Username does not exist');
        } else {
            $data = $user->data();
        } 
?>

<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>My Profile</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <div class="fade-in">
            <header>
                <a href= "index.php"><i class="fas fa-home"></i></a>
                <a href= "profile.php"><i class="fas fa-smile-wink"></i></a>
                <a href= "likes.php"><i class="fas fa-heart"></i></a>
                <a href= "update.php"><i class="fas fa-user-circle"></i></a>
                <button id="myBtn" style="color: white; border: none; cursor: pointer; background: none; width: 0; margin: 0; margin-left: 4%"><i class="fas fa-camera-retro"></i></button>
            </header>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Hi, take a pic and upload it!</h2>
                    <p>Make sure you click allow to use your cam, when you're 
                        done taking your pic, add a filter and upload it </p>
                    <div class="booth">
                        <img id="stick" style="position:absolute; width: 90%;">
                        <video id="video" width="100%"></video>
                        <br/>
                        <div class="cambuttons">
                            <a href ="#" id="capture" class="capturebtn">Take Photo</a>
                            <canvas id="sticker" width="400" height="300" style="position: absolute;top: 0px;left: 0px;z-index: 2;width: 100%;"></canvas>
                            <canvas id="canvas" width="500" height="380" ></canvas>
                            <button type="button" style="font-size: 1.8vh;" class="uploadbtn" onclick="camReset()">Retake</button>
                            <a href ="#" id="upload" class="uploadbtn">Post</a>
                        </div>
                        <div class="stickers">
                        <h3 style="margin: 0;">Stickers</h3>
                            <table style="width:100%">
                                <tr>
                                    <td><img id="place1" src="./stickers/s1ph.png" style="width: 70%;"></td>
                                    <td><img id="place2" src="./stickers/s2ph.png" style="width: 70%;"></td>
                                    <td><img id="place3" src="./stickers/s3ph.png" style="width: 70%;"></td>
                                    <td><img id="place4" src="./stickers/s4ph.png" style="width: 70%;"></td>
                                    <td><img id="place5" src="./stickers/s5ph.png" style="width: 70%;"></td> 
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
                <div class="profile">
                    <div class="usern"><h3 style="text-align: left; font-size: 3vh"> Username: <?php echo escape($data->username); ?></h3></div>
                    <div class="unamed"><h2 style="text-align: left;font-size: 2vh; padding-top: 2%"> Name: <?php echo escape($data->name);?> </h2></div>  
                </div>
                <?php
                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div id='imgsec'  style='width: 90%; margin: 0 auto;'>";
                        echo "<img src='" .$row['imgaddress']."' style='width: 40%;border: 2px solid black';>";
                        echo "<p style='color: rgb(58, 193, 255);margin: 1% auto; width: 40%;'> {$row['username']}</p>";
                        echo "</div>";
                    }
                ?>
            <script src="./js/modal.js"></script>
            <script src="./js/cam.js"></script>
            <!-- <script src="./js/noRclick.js"></script> -->
        </div>
    </body>
</html>
