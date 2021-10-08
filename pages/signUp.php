<?php
require '../util/functions.php';


// 1 : Insert berhasil
// 0 : Password dan confirmation password tidak match
// -1 : Username sudah ada di database
if (isset($_POST["register"])){
    $signUpValidation = signUp($_POST);
    if ($signUpValidation == 1){
        // echo "Signup Success";
        $Prompt = "Signup Success";
        $isValid = true;
    } else if ($signUpValidation == 0){
        // echo "Passwords and confirmation password don't match";
        $Prompt = "Passwords and Password Confirmation Don't Match";
        $isValid = false;
    } else {
        // echo "Username already taken";
        $Prompt = "Username is Already Taken";
        $isValid = false;
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <title>Signup-Welcome to The Book Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/LoginRegister.css">
    </head>
    <body>
        <div class="box">
            <div class="left-box">
                <h1 class="main-title">Sign up</h1>

                <?php if(isset($isValid) && $isValid==true) : ?>
                    <h5 class="subtitle prompt prompt-true"><?=$Prompt?></h5>
                <?php elseif (isset($isValid) && $isValid==false) : ?>
                    <h5 class="subtitle prompt"><?=$Prompt?></h5>
                <?php endif; ?>

                <form class="fill-form" action="" method="POST">
                    <ul>
                        <li>
                            <input class="input-text" type="text" name="username" placeholder="Username">
                        </li>
                        <li>
                            <input class="input-text" type="text" name="email" placeholder="E-mail Address">
                        </li>
                        <li>
                            <input class="input-text" type="password" name="password" placeholder="Password">
                        </li>
                        <li>
                            <input class="input-text" type="password" name="password-confirmation" placeholder="Password Confirmation">
                        </li>
                        <li>
                            <button class="submit btn" type="submit" name="register">Sign up</button>
                        </li>
                        <li>
                            <a class="alt"  href="login.php">Already have an account? Sign in</a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right-box">
                <h1 class="desc-box">Stand with Dorayaki</h1>
        </div>
        </div>
    </body>
</html>