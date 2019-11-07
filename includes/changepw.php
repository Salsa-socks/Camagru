<?php
    require_once '../core/init.php';

    $user = new User($username = Input::get('user'));
    $saltcheck = $_GET['salt'];
    $check = $user->data()->id;
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
                        $user->update(array(
                        'password' => Hash::make(Input::get('password_new'), $salt),
                        'salt' => $salt,
                        ),$check);
                        Session::flash('login', 'Your password has been changed');
                        Redirect::to('login.php');
            
                    } catch(Exception $e) {
                        die("Something went wrong validating your account, please register again, sorry, peasant..");
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
                    <input type="password" name="password_new" required="" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Password - Password needs to be 8 minimum characters, minimum 1 special character, 1 Capital letter amd 1 number')" autocomplete="off">
                    <br/>
                    <br/>
                </div>
                <div class="field">
                    <label for="name">Re Enter new password</label>
                    <input type="password" name="password_new_again" required="" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Password - Password needs to be 8 minimum characters, minimum 1 special character, 1 Capital letter amd 1 number & passwords must match')" autocomplete="off">
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