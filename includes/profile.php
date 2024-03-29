<?php
    require_once '../core/init.php';

    if (Session::exists('profile')) {
        echo '<p>' . Session::flash('profile') . '</p>';
    }
            // $username = Input::get('user');
            $user = new User();
            $id= $user->data()->id;
            $username = $user->data()->username;
            try {
                $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "failed to connect to server";
            }

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

        $countsql = $conn->prepare("SELECT COUNT(`imagename`) FROM `images`");
        $countsql->execute();
        $rowi = $countsql->fetch();
        $numrecords = $rowi[0];

        $numperpage = 5;
        $numlinks = ceil($numrecords/$numperpage);
        $page = isset($_GET['start']) ? $_GET['start'] : 0;
        if (!$page) {
            $page = 0;
        }
        $start = $page * $numperpage;

        $sql = "SELECT * FROM `images` ORDER BY `images`.`postdate` DESC LIMIT $start,$numperpage";
        $res = $conn->prepare($sql);
        $res->execute();

        $sql2 = "SELECT * FROM `images` WHERE username = '$username' ORDER BY `images`.`postdate` DESC LIMIT $start,$numperpage";
        $res2 = $conn->prepare($sql2);
        $res2->execute();

        // $res2 = $user->db()->get_user_images($username,$page);

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
                <a href= "update.php"><i class="fas fa-user-circle"></i></a>
                <button id="myBtn" style="color: white; border: none; cursor: pointer; background: none; width: 0; margin: 0; margin-left: 4%"><i class="fas fa-camera-retro"></i></button>
                <a href="logout.php" style="padding-left: 10%;">Log out</a>
            </header>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span id="refresh" class="close" style="font-size: 6vw;">&times;</span>
                    <div class="booth2">
                    <?php
                    while($row2 = $res2->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div id='imgsec2'>
                            <img src='<?php echo $row2['imgaddress'];?>' style='width: 100%;border: 2px solid black; margin-top: 0%;'>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
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
                    <div class="usern"><h3 style="text-align: left; font-size: 3vh; margin-left: 2%"> Username: <?php echo escape($data->username); ?></h3></div>
                    <div class="unamed"><h2 style="text-align: left;font-size: 2vh; padding-top: 2%; margin-left:2%"> Name: <?php echo escape($data->name);?> </h2></div>
                    <br/>
                </div>
                <?php
                for($i=0;$i<=$numlinks;$i++) {
                    $y = $i + 1;
                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div id='imgsec'>
                            <p style='color: rgb(244, 112, 239);margin: 1% auto; width: 40%;'><?php echo $row['username']; ?></p>
                            <img src='<?php echo $row['imgaddress'];?>' style='width: 40%;border: 2px solid black; margin-top: 0%;'>
                        </div>
                        <div class='symbolbox'>
                            <form action="../functions/like.php" method="post">
                            <input type="submit" value="like" id="like" style="width: 20%; font-size: 1.5vw; background: #39c1ff; color: white; font-family: Oswald;">
                            <input type="hidden" name="liker" value="<?php echo $id?>">
                            <input type="hidden" name="username" value="<?php echo $row['username'] ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            </form>
                            <?php 
                            if ($username === $row['username']) {?>
                                <form action="../functions/delete.php" method="post">
                                    <input type="hidden" name="username" value="<?php echo escape($data->username); ?>">
                                    <input type="hidden" name="id" value="<?php echo escape($row['id'])?>">
                                    <input type="hidden" name="imagename" value="<?php echo escape($row['imagename'])?>">
                                    <input type="submit" value="Delete" style="width: 20%;font-size: 1.5vw;background: #39c1ff;color: white;font-family: Oswald;">
                                </form>
                            <?php } ?>
                        </div>
                        <div class="comsec" style="width: 36%; margin: 0 auto;">
                            <input type=text id="comment-input-<?=$row['id']?>" style="width: 100%;"/>
                            <input type="button" value="submit" onclick="submit_comment(<?=$row['id']?>)" style="font-size: 1.5vw; width: 20%; background: #39c1ff; font-family: Oswald;color: white;"/>
                        <?php
                            $fetch_likes = "SELECT * FROM `likes` WHERE imageid=? ORDER BY `likes`.`postdate` DESC";
                            $res3 = $conn->prepare($fetch_likes);
                            $res3->execute(array($row['id']));
                            $likes = 0;
                            while ($rowl = $res3->fetch(PDO::FETCH_ASSOC)) {
                                $liker = $user->db()->get_property('username', 'users', array(
                                    'id', '=' ,$rowl['likerid']
                                ))[0]->username;
                                $likes = $user->db()->get_property_count('id','likes', 'imageid', $rowl['imageid']);
                            ?>
                                <div class="likes" style="color: #39c1ff; font-size:1.4vw;width: 100%;background: #f3f3f3;margin-top: 3%;"><?=$liker;?> likes this picture</div>
                            <?php
                            }
                            if ($likes) {
                                echo "<br/>";
                                echo $likes . " like(s)";
                            } else {
                                echo "";
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
                    echo '<a href="profile.php?start='.$i.'&user='.$username.'" style="font-size: 3vw; padding: 1%; background: white">'.$y.'</a>';
                }
                ?>
            <script src="./js/modal.js"></script>
            <script src="./js/cam.js"></script>
            <!-- <script src="./js/noRclick.js"></script> -->
        </div>
    </body>
    <footer>
        This is a footer for the markingsheet... bnkosi
    </footer>
</html>
