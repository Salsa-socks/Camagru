<?php
require_once '../core/init.php';

if (Session::exists('forgotpw')) {
    echo '<p>' . Session::flash('forgotpw') . '</p>';
}

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array('required' => true)
            ));

            if ($validation->passed()) {
                $user = new User($username = Input::get('username'));
                if (!$user->find($username)) {
                    Session::flash('home', 'No such User');
                    Redirect::to('../includes/index.php');
                } else {
                    $salt = $user->data()->salt;
                    $email = $user->data()->email;
                    $subject = 'Forgot password';
                    $message = 'Please click the link to change your password:';
                    $message .= "<a href='http://localhost:8080/Camagru/includes/changepw.php?user=$username&salt=$salt'>Change Password</a>";
                    $headers = 'From:noreply@camagru.co.bnkosi' . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
                    mail($email, $subject, $message, $headers);
                    Session::flash('login', 'Please check your email for a link to change your password');
                    Redirect::to('login.php');
                    echo "sent";
                }
            }
        }
    }
?>


<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>Change password</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <br/>
        <h2>Forgot My password</h2>
        <p style="text-align: center">Please enter your username and you will receive an email with a link to change your password</p>
        <div class="details">
            <form action="" method="post">
                </div>
                <div class="field">
                    <label for="username">Your Username</label>
                    <input type="text" name="username" id="username">
                </div>
                <input type="submit" value="Send Email" class="logbutton" style="width:50%;display: block;margin: 0 auto;">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            </form>
        </div>
    </body>
</html>