<?php

require_once "../core/init.php";

    $db = DB::getInstance();
    $username = Input::get('username');
    $email = ($db->get_property('email','users', array('username', '=', $username)))[0]->email;
    $likerid = Input::get("liker");
    $imageid = Input::get('id');
    $likername = $db->get_property('username', 'users', array('id', '=', $likerid))[0]->username;

    if ($lid = $db->get_like_id($likerid, $imageid)) {
        $lid = $lid[0]->id;
        $db->delete('likes', array('id', '=', $lid));
        Session::flash('profile', 'Image Un-liked!');
        Redirect::to('../includes/profile.php?start=0&user='.$likername);
    } else {
        if (($db->get_property('notify', 'users', array('username', '=', $username)))[0]->notify) {
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
        Redirect::to('../includes/profile.php?start=0&user='.$likername);
    }

?>