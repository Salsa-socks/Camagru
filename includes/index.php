<?php
    require_once '../core/init.php';
    
    $user = DB::getInstance()->insert('users', array(
        'username' => 'dummytwo',
        'password' => 'password',
        'salt' => 'salt'
    ));

?>