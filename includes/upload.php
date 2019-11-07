<?php
   require_once '../core/init.php';

   echo "WTF";
   $user = new User();
   $username= $user->data()->username;
   if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
    }
   $baseimage = $_POST["image"];
   echo $baseimage;

   if(!empty($layer1) && !empty($usern)){
    $baseimage = $usern.time().".png";
    $imagepath = "../../gallery/photos/".$baseimage;
    $imgurl = str_replace("data:image/png;base64,", "", $layer1);
    $imageurl = str_replace(" ", "+", $imgurl);
    $imgdecode = base64_decode($imageurl);
    file_put_contents($imagepath, $imgdecode);
   }

   


?>