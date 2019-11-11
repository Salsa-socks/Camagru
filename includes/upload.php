<?php
   require_once '../core/init.php';

   $user = new User();
   $username= $user->data()->username;
   if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
    }
   $layer1 = $_POST["baseimage"];
   $layer2 = $_POST["overlayimage"];

   echo $layer1;

   if(!empty($layer1) && !empty($username)){
    $baseimage = $username.time().".png";
    $imagepath = "./usergallery/".$baseimage;
    $imgurl = str_replace("data:image/png;base64,", "", $layer1);
    $imageurl = str_replace(" ", "+", $imgurl);
    $imgdecode = base64_decode($imageurl);
    file_put_contents($imagepath, $imgdecode);
   }

   if(isset($layer2)){
      $overlayimage = "overlay".time().".png";
      $overlaypath = "./usergallery/".$overlayimage;
      $imgurl = str_replace("data:image/png;base64,", "", $layer2);
      $imageurl = str_replace(" ", "+", $imgurl);
      $imgdecode = base64_decode($imageurl);
      file_put_contents($overlaypath, $imgdecode);
   }
   if(isset($layer1) && isset($layer2)){
         $dest = imagecreatefrompng($imagepath);
         $src = imagecreatefrompng($overlaypath);
         imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480, 500, 380); //size of overl
         imagepng($dest, $imagepath);
         imagedestroy($dest);
         imagedestroy($src);
         unlink($overlaypath);
   }
   if (isset($layer1) && isset($layer2)) {
      try {
         $sql = DB::insert('images',array(
            'imagename' => $baseimage,
            'username' => $username,
            'postdate' => date('Y-m-d H:i:s')
         ));
         alert('Image posted, please refresh :)');
      } catch (Exception $e) {
         alert('unable to post image');
      
   }
   



   return 0;
?>