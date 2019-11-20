<?php
    require_once '../core/init.php';
    
    if (Session::exists('home')) {
        echo '<p>' . Session::flash('home') . '</p>';
    }
    $username = Input::get('user');
    $user = new User($username);
    
    try {
        $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "failed to connect to server";
    }

    $countsql = $conn->prepare("SELECT COUNT(`imagename`) FROM `images`");
    $countsql->execute();
    $rowi = $countsql->fetch();
    $numrecords = $rowi[0];

    $numperpage = 2;
    $numlinks = ceil($numrecords/$numperpage);
    $page = isset($_GET['start']) ? $_GET['start'] : 0;
    if (!$page) {
        $page = 0;
    }
    $start = $page * $numperpage;

    $sql = "SELECT * FROM `images` ORDER BY `images`.`postdate` DESC LIMIT $start,$numperpage";
    $res = $conn->prepare($sql);
    $res->execute();

?>

<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>Home</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="/Camagru/includes/js/feed.js"></script>
    </head>
    <body>
        <div class="fade-in">
            <div class="landinginfo">
                    <p style="font-size: 3vw">Welcome to</p>
                    <br/>
                    <div class="superheader"><h4>CAMAGRU</h4></div>
                    <?php
                    $loggedin = 0;
                    $user = new User();
                    if($user->isLoggedin()) {
                        $id= $user->data()->id;
                        $loggedin = 1;
                    ?>
                    <p style="margin-top: -2vh; text-shadow: 3px 2px 1px #ffffff; font-size:5vw">Hello <a href='profile.php?user=<?php echo escape($user->data()->username); ?>'><?php echo escape($user->data()->username); ?></a>!</p>
                    <a href="logout.php" style="font-size: 3vw;">Log out</a>
                    <?php
                    } else {
                        echo '<p style="margin-top: -2vh; text-shadow: 3px 2px 1px #ffffff; font-size: 3vw;"> You need to <a href="login.php">log in</a> or <a href="register.php">register</a>, peasant </p>';
                    }
                    ?>

                <?php
                for($i=0;$i<=$numlinks;$i++) {
                    $y = $i + 1;
                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div id='imgsec'>
                            <p style='color: rgb(244, 112, 239);margin: 1% auto; width: 40%;'><?php echo $row['username']; ?></p>
                            <img src='<?php echo $row['imgaddress'];?>' style='width: 40%;border: 2px solid black; margin-top: 0%;'>
                        </div>
                        <?php if ($loggedin == 1) {
                            ?>
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
                        }
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
                            <br/>
                            <br/>
                            <br/>
                        </div>
                        <?php
                    }
                    
                    echo '<a href="index.php?start='.$i.'&user='.$username.'" style="font-size: 3vw; padding: 1%; background: white; width: 30%; margin: 0 auto;">'.$y.'</a>';
                }
                ?>
                <br/>
                <br/>
                <br/>
                </div>
            </div>
        </div>
    </body>
</html>