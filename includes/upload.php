<?php
   require_once '../core/init.php';

   $user = new User();
   $username= $user->data()->username;
   if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
    }
   $layer1 = $_POST["baseimage"];

   if(!empty($layer1) && !empty($username)){
    $baseimage = $username.time().".png";
    $imagepath = "./usergallery/".$baseimage;
    $imgurl = str_replace("data:image/png;base64,", "", $layer1);
    $imageurl = str_replace(" ", "+", $imgurl);
    $imgdecode = base64_decode($imageurl);
    file_put_contents($imagepath, $imgdecode);
   }

?>