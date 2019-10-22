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
        <input type="text" placeholder="Enter your name" name="name" required>

        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter desired username" name="username" required>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <label for="psw_repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw_repeat" required>
    <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="index.php">Sign in</a>.</p>
  </div>
</form>
</body>