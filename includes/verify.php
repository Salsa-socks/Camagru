<?php
    require_once '../core/init.php';

        $conn = new User();
        $user = new User(Input::get('user'));
        $check = $user->data()->id;
        $saltcheck = $_GET['salt'];
        if ($check) {
            
            try {
                $conn->update(array(
                    'emailconfirm' => 1
                ), $check);
                Redirect::to('login.php');

            } catch(Exception $e) {
                die("Something went wrong validating your account, please register again, sorry, peasant..");
            }
        }
?>