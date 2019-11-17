<?php

require_once "../core/init.php";

// if (isset($_GET['type'], $_GET['id'])) {
//     $type = $_GET['type'];
//     $id = (int)$_GET['id'];

//     switch($type) {
//         case 'image':
//             $stmt = "INSERT INTO `likes` (`userid`, `imageid`) SELECT {$_SESSION[userid]}, {id} FROM `likes` WHERE EXISTS(
//                 SELECT `id` FROM `images` WHERE `id` = {$id}) AND NOT EXISTS (SELECT `id` FROM `likes` WHERE `user`= {$_SESSION['user']} AND `likes` = {$id})";
//             $stmt = $conn->prepare($stmt);
//         break;
//     }
// }
    $db = DB::getInstance();
    $username = Input::get('username');
    $email = ($db->get_property('email','users', array('username', '=', $username)))[0]->email;
    $likerid = Input::get("liker");
    $imageid = Input::get('id');

    if ($lid = $db->get_like_id($likerid, $imageid)) {
        var_dump($lid);
        $lid = $lid[0]->id;
        $db->delete('likes', array('id', '=', $lid));
        Session::flash('profile', 'Image Un-liked!');
        Redirect::to('../includes/profile.php');
    } else {
        if (($db->get_property('notify', 'users', array('username', '=', $username)))[0]->notify) {
            var_dump($lid);
            $subject = 'Congrats, dont kill yourself yet, someone likes you';
            $message = 'Thank you for getting liked...';
            $message .= "\r\n";
            $headers = 'From:noreply@camagru.co.bnkosi' . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
            mail($email, $subject, $message, $headers);

        }
        $db->insert('likes', array(
            'imageid' => $imageid,
            'username' => $username,
            'likerid' => $likerid,
            'postdate' => date('Y-m-d H:i:s')
        ));
        Session::flash('profile', 'Image liked!');
        Redirect::to('../includes/profile.php');
    }

?>