<?php
    require_once '../core/init.php';
    
    if (Session::exists('success')) {
        echo Session::flash('success');
    }
    // $user = DB::getInstance()->insert('users',array(
    //     'username' => 'bob',
    //     'password' => 'password',
    //     'salt' => 'salt',
    //     'name' => 'bobby',
    //     'group' => '1',
    //     'email' => 'emailmsdfndl',
    //     'joined' => date('Y-m-d H:i:s')
    // ));

    // if(!$user)
    // {
    //     echo "failure"; //failure to connect to database.
    // }
?>