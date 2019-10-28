<?php
    require_once '../core/init.php';
    
    if (Session::exists('home')) {
        echo '<p>' . Session::flash('home') . '</p>';
    }
    
    // if(!$user)
    // {
    //     echo "failure"; //failure to connect to database.
    // }
?>