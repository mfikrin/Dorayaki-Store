<?php
session_start();
require '../util/functions.php';

// Check if cookie exists
if (isset($_COOKIE['usernameEmail']) && isset($_COOKIE['key'])){
    $key = $_COOKIE['key'];
    $userEmail = $_COOKIE['usernameEmail'];
    $isCookieValid = isEmailUsernameExistEncrypt($userEmail, $key);
    if ($isCookieValid>=1){
        // if useremail dan key in cookie is verified, make a session
        $_SESSION['login']= true;
        $_SESSION['usernameEmail'] = $userEmail;
        // Make session for admin, if the associated username is an admin
        if ($isCookieValid==2){
            $_SESSION['is_admin'] = true;
        }
        else{
            $_SESSION['is_admin'] = false;
        }
    }
}

// Check if session exists
if(isset($_SESSION["login"])){
    header("Location: ../index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <title>Login-welcome to Stand with Dorayaki</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/LoginRegister.css">
    </head>
    <body>
        <!-- <?php if(isset($error) && $error==true) : ?>
            <?php
                if ($loginValidation == 0) {
                    // echo "Invalid Password, Check Your Password Again";
                    $invalidPrompt = "Invalid Password, Check Your Password Again";
                } else if ($loginValidation == -1) {
                    // echo "Email/username Not Registered";
                    $invalidPrompt = "Email/Username Not Registered";
                }
            ?>
        <?php endif; ?> -->

        <div class="box split-screen">
            <div class="left-box left-box-signin">
                <section class="copy">
                    <h1 class="main-title signin">Login</h1>

                    <ul class="form-messages" id="form-messages"></ul>

                    <form class="fill-form" >
                        <ul>
                            <li>
                                <input class="input-text" type="text" id="usernameEmail" name="usernameEmail" placeholder="Username" required>
                            </li>
                            <li>
                                <input class="input-text"  type="password" id="password" name="password" placeholder="Password" required>
                            </li>
                            <li>
                                <input class="checkbox" type="checkbox" id="remember" name="remember" id="remember" placeholder="Remember me">
                                <label class="checkbox" for="remember">Remember me</label>
                            </li>
                            <li>
                                <button class="submit btn" type="button" id="submit-btn" name="login">Log in</button>
                            </li>
                            <li>
                                <a class="alt" href="signUp.php">Don't have an account? Sign Up</a>
                            </li>
                        </ul>
                    </form>
                </section>
            </div>

            <div class="right-box right-box-signin">
                <h1 class="desc-box">Stand with Dorayaki</h1>
                <p class="desc-quote">"We have all kinds of Dorayakis" -Doraemon</p>
            </div>
        </div>

        <script>
            const cb = document.getElementsByClassName('checkbox')[0];
            console.log(cb.checked);
            
            const form = {
                usernameEmail: document.getElementById('usernameEmail'),
                password: document.getElementById('password'),
                // checkbox: document.getElementById('usernameEmail'),
                submit: document.getElementsByClassName('submit btn')[0],
                messages: document.getElementById('form-messages')
            };

            form.submit.addEventListener('click', () => {
                console.log(cb.checked);

                // event.preventDefault();
                const request = new XMLHttpRequest();

                request.onload = () => {
                    let responseObject = null;

                    try {
                        responseObject = JSON.parse(request.responseText);
                    } catch (e) {
                        console.error('Error when parsing JSON!');
                    }

                    if (responseObject) {
                        handleResponse(responseObject);
                    }
                };

                const requestData = `usernameEmail=${form.usernameEmail.value}&password=${form.password.value}&checkbox=${cb.checked}`;
                // console.log(requestData);

                request.open('post', '../util/loginFunction.php');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.send(requestData);
            });

            function handleResponse (responseObject) {
                if (responseObject.validation) {
                    location.href = '../index.php';
                } else {
                    while (form.messages.firstChild) {
                        form.messages.removeChild(form.messages.firstChild);
                    }

                    responseObject.messages.forEach((message) => {
                        const li = document.createElement('li');
                        li.textContent = message;
                        form.messages.appendChild(li);
                    });

                    // Changing the color of border for validation
                    
                    if (responseObject.errorCode == -2) { // If there's empty field
                        if (form.usernameEmail.value ==''){
                            form.usernameEmail.style.borderColor = "red";
                        }
                        if (form.password.value ==''){
                            form.password.style.borderColor = "red";
                        } 
                    } else if (responseObject.errorCode == -1) { // If username already registered
                        form.usernameEmail.style.borderColor = "red";
                    } else if (responseObject.errorCode == 0) { // Wrong password
                        form.password.style.borderColor = "red";
                    }

                    form.messages.style.display = "block";
                }
            }

        </script>

    </body>
</html>