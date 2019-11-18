<?php
    require_once '../core/init.php';

    if (Session::exists('profile')) {
        echo '<p>' . Session::flash('profile') . '</p>';
    }

        $username = Input::get('user');
        $user = new User($username);
        $id= $user->data()->id;
        try {
            $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "failed to connect to server";
        }
        $sql = "SELECT * FROM `images` ORDER BY `images`.`postdate` DESC";
        $res = $conn->prepare($sql);
        $res->execute();

        if (!$user->exists()) {
            Redirect::to('./errors/404.php');
            Session::flash('404','you need to login');
        } else {
            $data = $user->data();
        }

        if (isset($_POST['picup'])) {
            
            $file = $_FILES['upimage'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            if ($fileTmpName)
            {
                list($width, $height) = getimagesize($fileTmpName);


                $tmp = imagecreatetruecolor(500, 375);

                $tmp_path = "./usergallery/tmp/tmp.png";

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                switch($fileActualExt) {
                    case "jpg":
                        $source = imagecreatefromjpeg($fileTmpName);
                        break;
                    case "jpeg":
                        $source = imagecreatefromjpeg($fileTmpName);
                        break;
                    case "png":
                        $source = imagecreatefrompng($fileTmpName);
                        break;
                }
                imagecopyresampled($tmp , $source , 0, 0, 0 , 0, 500 , 375 , $width , $height );
                imagepng($tmp, $tmp_path, 9);
            }         
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
        <script src="/Camagru/includes/js/feed.js"></script>
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
                    <span id="refresh" class="close">&times;</span>
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
                            <a href="#" id="upload" class="uploadbtn">Post</a>
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
                            <br/>
                            <div id="mypicupload">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="file">
                                    <div>
                                        <label for="upimage" class="upbtn1">Choose a file to upload</label>
                                        <input type="file" name="upimage" id="upimage">
                                    </div>
                                    <div>
                                    <label for="picup" class="upbtn1">Click upload to upload it</label>
                                        <button type="submit" name="picup" id="picup" style="display: none;">
                                    </div>
                                </form>
                                <a href="#" id="testbtn" class="upbtn1" onclick="uploader()">View Upload</a>
                            </div>
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
                        ?>
                        <div id='imgsec'>
                            <p style='color: rgb(58, 193, 255);margin: 1% auto; width: 40%;'><?php echo $row['username']; ?></p>
                            <img src='<?php echo $row['imgaddress'];?>' style='width: 40%;border: 2px solid black; margin-top: 0%;'>
                        </div>

                        <div class='symbolbox'>
                            <form action="../functions/like.php" method="post">
                            <input type="submit" value="like" id="like" style="width: 20%; font-size: 1.5vw; background: #39c1ff; color: white; font-family: Oswald;">
                            <input type="hidden" name="liker" value="<?php echo $id?>">
                            <input type="hidden" name="username" value="<?php echo $row['username'] ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            </form>
                        </div>
                        <div class="comsec" style="width: 36%; margin: 0 auto;">
                            <input type=text id="comment-input-<?=$row['id']?>" style="width: 100%;"/>
                            <input type="button" value="submit" onclick="submit_comment(<?=$row['id']?>)" style="font-size: 1.5vw; width: 20%; background: #39c1ff; font-family: Oswald;color: white;"/>
                        <?php
                            $fetch_likes = "SELECT * FROM `likes` WHERE imageid=? ORDER BY `likes`.`postdate` DESC";
                            $res3 = $conn->prepare($fetch_likes);
                            $res3->execute(array($row['id']));
                            while ($rowl = $res3->fetch(PDO::FETCH_ASSOC)) {
                                $poster = $user->db()->get_property('username', 'users', array(
                                    'id', '=' ,$rowl['likerid']
                                ))[0]->username;
                            ?>
                                <div class="likes" style="color: #39c1ff; font-size:1.4vw;width: 100%;background: #f3f3f3;margin-top: 3%;"><?=$poster;?> likes your picture</div>
                            <?php
                            }
                            $fetch_comments = "SELECT * FROM `comments` WHERE `imageid`=? ORDER BY `comments`.`postdate` DESC";
                            $res2 = $conn->prepare($fetch_comments);
                            $res2->execute(array($row['id']));
                            while ($comment = $res2->fetch(PDO::FETCH_ASSOC)):
                        ?>
                                <div class="thecomments" style="width: 100%; background: #f3f3f3; margin-top: 2%"><?php echo escape ($comment['comment'])?></div>
                        <?php
                            endwhile;
                        ?>
                            
                        </div>
                        <?php
                    }
                    ?>
            <script src="./js/modal.js"></script>
            <script src="./js/cam.js"></script>
            <!-- <script src="./js/noRclick.js"></script> -->
        </div>
    </body>
</html>
