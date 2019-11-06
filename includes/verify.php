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


    // //////////////////////////////////////////////////////////////////
    // $conn = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // $update = "UPDATE users SET emailconfirm = 1 WHERE id=$check";

    // $stmt = $conn->prepare($update);
    // $stmt->execute();

    // echo $stmt->data()->id;

?>