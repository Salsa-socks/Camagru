<?php
    require_once '../core/init.php';

    $user = new User();
    $id= $user->data()->id;
    if (!$user->isLoggedIn()) {
        Redirect::to('index.php');
    }

    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                ),
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'email' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                  )  
                ));
                if($validation->passed()) {
                    try {
                        $user->update(array(
                            'name' => Input::get('name'),
                            'username' => Input::get('username'),
                            'email' => Input::get('email')
                        ),$id);
                        Session::flash('home', 'Your details have been updated');
                        Redirect::to('profile.php');

                    } catch(Exception $e) {
                        die($e->getMessage());
                    }
                }else {
                    foreach($validation->errors() as $error) {
                        echo $error, '<br>';
                    }
                }
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel = "icon" href="./img/logowhite.png" type = "image/x-icon"> 
        <title>Update</title>
        <script src="https://kit.fontawesome.com/fcfc638980.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,600,700&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <header>
            <a href= "index.php"><i class="fas fa-home"></i></a>
            <a href= "search.php"><i class="fas fa-search"></i></a>
            <a href= "likes.php"><i class="fas fa-heart"></i></a>
            <a href= "profile.php"><i class="fas fa-user-circle"></i></a>
            <button id="myBtn" style="color: white; border: none; cursor: pointer; background: none; width: 0;
margin: 0; margin-left: 4%"><i class="fas fa-camera-retro"></i></button>
        </header>
        <br/>
        <h2>Update Your details</h2>
        <div class="details">
            <form action="" method="post">
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?php echo escape($user->data()->name);?>" required="" >
                    <br/>
                    <br/>
                    <label for="name">Username</label>
                    <input type="text" name="username" value="<?php echo escape($user->data()->username);?>" required="" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid, Username needs to be minimum 5 characters, minimum 1 special character, 1 Capital letter amd 1 number')">
                    <br/>
                    <br/>
                    <label for="name">Email Address</label>
                    <input type="text" name="email" value="<?php echo escape($user->data()->email);?>" required="" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Email')">
                    <br/>
                    <br/>
                    <h3>Click "Update" to update your details</h3>
                    <input type="submit" value="Update">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </div>
            </form>
        </div>
    </body>
</html>