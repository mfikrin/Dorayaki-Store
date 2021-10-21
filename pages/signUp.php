<?php
session_start();
require '../util/functions.php';

?>


<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <title>Signup-Welcome to Stand with Dorayaki</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/LoginRegister.css">
    </head>
    <body>
        <div class="box split-screen">
            <div class="left-box left-box-signup">
                <section class="copy">
                    <h1 class="main-title">Sign up</h1>

                    <ul class="form-messages" id="form-messages"></ul>

                    <form class="fill-form" action="" method="POST">
                        <ul>
                            <li>
                                <input class="input-text input-text-username-signup" type="text" id="username" name="username" placeholder="Username">
                                <div class="box-message" id="box-message-username">Haloo</div>
                            </li>
                            <li>
                                <input class="input-text input-text-email-signup" type="text" id="email" name="email" placeholder="E-mail Address">
                                <div class="box-message" id="box-message-email">Haloo</div>
                            </li>
                            <li>
                                <input class="input-text password" type="password" id="password" name="password" placeholder="Password">
                            </li>
                            <li>
                                <input class="input-text password-confirmation" type="password" id="password-confirmation" name="password-confirmation" placeholder="Password Confirmation">
                            </li>
                            <li>
                                <button class="submit btn" type="button" id="register" name="register">Sign up</button>
                            </li>
                            <li>
                                <a class="alt"  href="login.php">Already have an account? Sign in</a>
                            </li>
                        </ul>
                    </form>
                </section>
            </div>

            <div class="right-box">
                <h1 class="desc-box">Stand with Dorayaki</h1>
                <p class="desc-quote">"We have all kinds of Dorayakis" -Doraemon</p>
            </div>
        </div>

        <script>
            const leftBox = document.getElementsByClassName("left-box-signup")[0];
            const form = {
            username: document.getElementById('username'),
            email: document.getElementById('email'),
            password: document.getElementById('password'),
            passwordConfirmation: document.getElementById('password-confirmation'),
            submit: document.getElementsByClassName('submit btn')[0],
            messages: document.getElementById('form-messages')
            };

            let boxMessage = document.getElementById('box-message-email');
            let boxMessageUsername = document.getElementById('box-message-username');

            // Check validation for email
            form.email.onkeydown = function(){
                const regex = /^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,8}$/;
                const regexo = /^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,3}\.[a-zA-Z]{1,3}$/;
                if (regex.test(form.email.value) || regexo.test(form.email.value)){
                    boxMessage.innerText = "Email yang dimasukkan valid";
                    form.email.style.borderColor = "lime";
                    boxMessage.style.color = "green";
                    boxMessage.style.display = "none";
                } else {
                    boxMessage.innerText = "Email tidak valid";
                    form.email.style.borderColor = "red";
                    boxMessage.style.display = "block";
                    boxMessage.style.color = "red";
                }
            }
            // check validation for usernmae
            form.username.onkeydown = function() {
                const regex = /^([\.\_a-zA-Z0-9]+)$/;
                if (regex.test(form.username.value)){
                    boxMessageUsername.innerText = "Username yang dimasukkan valid";
                    form.username.style.borderColor = "lime";
                    boxMessageUsername.style.color = "green";
                    boxMessageUsername.style.display = "none";
                } else {
                    boxMessageUsername.innerText = "Hanya boleh mengandung karakter, angka, '_'";
                    form.username.style.borderColor = "red";
                    boxMessageUsername.style.display = "block";
                    boxMessageUsername.style.color = "red";
                }
            }


            form.submit.addEventListener('click', () => {
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

                const requestData = `username=${form.username.value}&email=${form.email.value}&password=${form.password.value}&passwordConfirmation=${form.passwordConfirmation.value}`;
                // console.log(requestData);

                request.open('post', '../util/signUpFunction.php');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.send(requestData);
            });

            function handleResponse (responseObject) {
                if (responseObject.validation) {
                    location.href = '../pages/login.php';
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
                    if (responseObject.errorCode == -2) {
                        if (form.username.value ==''){
                            form.username.style.borderColor = "red";
                        }
                        if (form.email.value ==''){
                            form.email.style.borderColor = "red";
                        }
                        if (form.password.value ==''){
                            form.password.style.borderColor = "red";
                        }
                        if (form.passwordConfirmation.value ==''){
                            form.passwordConfirmation.style.borderColor = "red";
                        }
                    } else if (responseObject.errorCode == -1) {
                        form.username.style.borderColor = "red";
                    } else if (responseObject.errorCode == 0) {
                        form.password.style.borderColor = "red";
                        form.passwordConfirmation.style.borderColor = "red";
                    }

                    form.messages.style.display = "block";
                    // leftBox.style.paddingTop = "20px";
                }
            }


        </script>
    </body>
</html>