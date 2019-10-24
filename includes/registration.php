<?php
  require_once '../core/init.php';

  if (Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'username' => array(
            'required => true',
            'min' => 2,
            'max' => 20,
            'unique' => 'users'
        ),
        'password' => array(
            'required' => 'true',
            'min' => 6,
        ),
        'password_again' => array(
            'required' => 'true',
            'matches' => 'password',
        ),
        'name' => array(
            'required' => 'true',
            'min' => 2,
            'max' => 50,
        ) 
      ));
      if ($validation->passed()){
        //register user
      }else {
        //output errors
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
    <title>Registration</title>
</head>
<body>
    <div class="logobox">
        <img src="./img/logo.png">
    </div>
<form action="registration.php">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

        <label for="name"><b>Name</b></label>
        <input type="text" placeholder="Enter your name" name="name">

        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter desired username" name="username" value="" >

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" >

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" >

        <label for="password_again"><b>Re-enter Password</b></label>
        <input type="password" placeholder="Repeat Password" name="passwaord_again" value="" >
    <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="index.php">Sign in</a>.</p>
  </div>
</form>
</body>