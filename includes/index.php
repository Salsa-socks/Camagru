<?php
    require_once '../core/init.php';
    
    $user = DB::getInstance()->get('users', array('username', '=', 'dummy'));

    if (!$user->count()){
        echo 'No User';
    } else {
        echo 'OK!';
    }
?>