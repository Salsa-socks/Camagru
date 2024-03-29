<?php
  require_once '../core/init.php';
  // session_destroy();
  if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
          'username' => array(
              'required' => true,
              'min' => 2,
              'max' => 20,
              'unique' => 'users'
          ),
          'password' => array(
              'required' => true,
              'min' => 6,
              'max' => 20
          ),
          'password_again' => array(
              'required' => true,
              'matches' => 'password'
          ),
          'name' => array(
              'required' => true,
              'min' => 2,
              'max' => 50
          ),
          'email' => array(
            'required' => true,
            'min' => 2,
            'max' => 50
          )
        ));
        
        if ($validation->passed()){
          $user = new User();
          $salt = Hash::salt(32);
          try {
            $user->create(array(
              'username' => Input::get('username'),
              'password' => Hash::make(Input::get('password'), $salt),
              'name' => Input::get('name'),
              'email' => Input::get('email'),
              'salt' => $salt,
              'joined' => date('Y-m-d H:i:s'),
              'group' => '1',
              'emailconfirm' => '0',
              'notify' => '1',
            ));
            $email = Input::get('email');
            $username = Input::get('username');
            $subject = 'Signup | Verification';
            $message = 'Thank you for registerimg. Please click the link to verify your registration:';
            $message .= "\r\n";
            $message .= "<a href='http://localhost:8080/Camagru/includes/verify.php?user=$username&salt=$salt'>Register Account</a>";
            $headers = 'From:noreply@camagru.co.bnkosi' . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
            mail($email, $subject, $message, $headers);
            
            Redirect::to('thankyou.php');
            
          } catch (Exception $e) {
            die($e->getMessage());
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
    <link rel="stylesheet" href="./css/reg.css">
    <meta charset="UTF-8">
    <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div class="fade-in">
    <div class="logobox">
        <img src="./img/logo.png">
    </div>
    <form action="" method='post'>
      <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter your name" name="name" value="<?php echo escape(Input::get("name"));?>" id ="name" required="">

            <label for="username"><b>Username</b></label>
            <input type="text" id ="username" placeholder="Enter desired username" required="" name="username" value ="<?php echo escape(Input::get('username'));?>" pattern="^[A-Z]+[a-z]+[0-9]+$" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid, Username needs to be minimum 5 characters, minimum 1 special character, 1 Capital letter amd 1 number')">

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required="" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Email')">

            <label for="password"><b>Password</b></label>
            <input type="password" id="password" placeholder="Enter Password" name="password" required="" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Password - Password needs to be 8 minimum characters, minimum 1 special character, 1 Capital letter amd 1 number')" autocomplete="off">

            <label for="password_again"><b>Re-enter Password</b></label>
            <input type="password" placeholder="Repeat Password" name="password_again" id="password_again" required="">
        <hr>
        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
        <input type="submit" class="registerbtn" value="Register"></button>
      </div>
      
      <div class="container signin">
        <p>Already have an account? <a href="login.php">Sign in</a>.</p>
      </div>
    </form>
</div>
</body>