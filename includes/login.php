<?php
  require_once '../core/init.php';
  if (Session::exists('login')) {
      echo '<p>' . Session::flash('login') . '</p>';
  }
  if(Input::exists()){
    if(Token::check(Input::get('token'))) {
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'username' => array('required' => true),
        'password' => array('required' => true)
      ));

      if($validation->passed()) {
        $user = new User();
        $remember = (Input::get('remember') === 'on') ? true : false;
        $login = $user->login(Input::get('username'), Input::get('password'), $remember);
        if ($user->data()->emailconfirm == 1) {
            if($login) {
              Redirect::to('../includes/profile.php');
            } else {
              Redirect::to('./errors/404.php');
            }
        }
      } else {
        foreach($validation->errors() as $error) {
          echo $error, '<br>';
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/main.css">
    <meta charset="UTF-8">
    <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>
</head>
<body style="background-image: url(./img/back2.png); background-size: unset;">
<div class="fade-in">
    <div class="container">
        <div class="frame">
            <div class="logobox">
                <img src="./img/logo.png">
            </div>
            <h2>Login</h2>
            <form action="" method="post">
                <div class="container2">
                  <label for="username"><b>Username</b></label>
                  <input type="text" placeholder="Enter Username" name="username" id="username">
                  <label for="psw"><b>Password</b></label>
                  <input type="password" placeholder="Enter Password" name="password" id="password">     
                  <input type="submit" value="Login" class="logbutton">
                  <label for="remember"><input type="checkbox" checked="checked" name="remember" id="remember">Remember me</label>
                  <br/>
                  <br/>
                  <span class="psw">Forgot <a href="forgotpw.php">password?</a></span>
                </div>
                <div class="container3">
                    <a href="register.php" class="regbutton" >Dont have an Account-Register Here</a>
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            </form>
        </div>
    </div>
</div>
</body>
</html>