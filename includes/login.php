<?php
  require_once '../core/init.php';

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

        if($login) {
          Redirect::to('user.php');
        } else {
          Redirect::to('register.php');
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
<body>
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
                </div>
                <div class="container3">
                    <button type="button" class="cancelbtn">Cancel</button>
                    <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            </form>
            <a href="register.php"><button type="register" style="background: rgb(0, 90, 132); margin-top:5%; width: 60% margin: 0 auto;">Dont have an Account-Register Here</button></a>
        </div>
    </div>
    <div class="waveWrapper waveAnimation">
          <div class="waveWrapperInner bgTop">
            <div class="wave waveTop" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-top.png')"></div>
          </div>
          <div class="waveWrapperInner bgMiddle">
            <div class="wave waveMiddle" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-mid.png')"></div>
          </div>
          <div class="waveWrapperInner bgBottom">
            <div class="wave waveBottom" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-bot.png')"></div>
          </div>
    </div>
</body>
</html>