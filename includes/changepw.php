<?php
    require_once '../core/init.php';

    $user = new User();
    $user = new User(Input::get('user'));
    $saltcheck = $_GET['salt'];

    if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password_new' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_new_again' => array(
                    'required' => true,
                    'min' => 6,
                    'matches' => 'password_new'
                )
            ));

            if($validation->passed()) {
                }
                    $salt = Hash::salt(32);
                    try {
                        $conn->update(array(
                        'password' => Hash::make(Input::get('password_new'), $salt),
                        'salt' => $salt,
                        ));
                        Session::flash('home', 'Your password has been changed');
                        Redirect::to('login.php');
            
                    } catch(Exception $e) {
                        die("Something went wrong validating your account, please register again, sorry, peasant..");
                    }
            } else {
                foreach($validation->errors() as $error) {
                    echo $error;
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
        <h2>Enter a New password</h2>
        <div class="details" >
            <form action="" method="post">
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
                </div>
                <div class= "Sendinfo">
                    <h3>Click "Change" to change your password</h3>
                    <input type="submit" value="Change" style="font-size: 2vw; border-radius: 0px !important; background: rgb(58, 193, 255); font-family: Oswald; width: 18vh; height: 5%; color: white;">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </div>    
            </form>
        </div>
    </body>
</html>