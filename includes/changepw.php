<?php
    require_once '../core/init.php';

    $user = new User();

    if(!$user->isLoggedin()) {
        Redirect::to('index.php');
    }

    if (Input::exists()) {
        if(Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password_current' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_new' => array(
                    'required' => true,
                    'mni' => 6
                ),
                'password_new_again' => array(
                    'required' => true,
                    'min' => 6,
                    'matches' => 'password_new'
                )
            ));

            if($validation->passed()) {
                if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
                    
                }
            } else {
                foreach($validation->errors() as $error) {
                    echo $error;
                }
            }
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>Document</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <br/>
        <h2>Change Your Password</h2>
        <div class="details">
            <form action="" method="post">
                <div class="field">
                    <label for="name">Current Password</label>
                    <input type="text" name="password_current" id="password_current">
                    <br/>
                    <br/>
                </div>
                <div class="field">
                    <label for="name">New Password</label>
                    <input type="text" name="password_new">
                    <br/>
                    <br/>
                </div>
                <div class="field">
                    <label for="name">Re Enter new password</label>
                    <input type="text" name="password_new_again">
                    <br/>
                    <br/>
                </div>
                    <h3>Click "Change" to change your password</h3>
                    <input type="submit" value="Change">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            </form>
        </div>
    </body>
</html>