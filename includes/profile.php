<?php
    require_once '../core/init.php';

    if (!$username = Input::get('user')) {
        Redirect::to('profile.php');
    } else {
        $user = new User($username);
        if (!$user->exists()) {
            Redirect::to(404);
        } else {
            $data = $user->data();
        }
?>
        <h3><?php echo escape($data->username); ?></h3>
        <p>Full name: <?php echo escape($data->name); ?> </p>
        <p>Email: <?php echo escape($data->email); ?> </p> 
        <?php
    }
?>

