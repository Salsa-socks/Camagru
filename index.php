<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instaclone</title>
</head>
<body>
    <div class="container">
        <div class="frame">
            <div class="logobox">
            <img src="./img/logo.png">
            </div>
            <h2>Login</h2>
            <form action="/action_page.php" method="post">
            <div class="container2">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container3" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>
        </div>
    </div>
</body>
</html>