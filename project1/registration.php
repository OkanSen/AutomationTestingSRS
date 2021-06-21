<?php include('server.php')   ?>

<html lang="en">
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <link rel="stylesheet" type="text/css" href="registration_style.css">
        
         
    </head>
    <body>
  
        
        <div class="loginbox">
            <img src="bilkent2.png" class="avatar">

                <h1 id="login-header">Bilkent Sign-up </h1>

                <div id="login-error-msg-holder">
                    <p id="login-error-msg">Password is too short (minimum is 6 characters). </p>
                    <p id="login-error-msg2">Any field cannot be blank!</p>
                    <p id="login-error-msg3">Email is not correct please check your @ sign and suffix/prefix</p>
                    <p id="login-error-msg4">The email id already exists</p>
                    <p id="login-error-msg5">The email is now registered</p>
                    <p id="login-error-msg6">The passwords do not match check your password entries!</p>
                </div>


                <form method="post" id="registration-form" action="registration.php">
                    <p id=id-header>Email</p>
                    <input type="text" name="email" id="email-field" class="registration-form-field" placeholder="">
                    <p id=id-pass>Password</p>
                    <input type="password" name="password" id="password-field" class="registration-form-field" placeholder="">
                    <p id=id-repass>Re-Enter Password</p>
                    <input type="password" name="re-password" id="re-password-field" class="registration-form-field" placeholder="">
                    <input type="button" value="Sign Up" id="registration-form-submit">
                    <a href="login.php" class= "ca"> Already have an account?</a>
                </form>

             

        </div> 
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous"></script>
        <script type="text/javascript">

            $(document).ready(function(){
          
                const loginErrorMsg = document.getElementById("login-error-msg");
                const loginErrorMsg2 = document.getElementById("login-error-msg2");
                const loginErrorMsg3 = document.getElementById("login-error-msg3");
                const loginErrorMsg4 = document.getElementById("login-error-msg4");
                const loginErrorMsg5 = document.getElementById("login-error-msg5");
                var loginAttempts = 3;
                const loginErrorMsg6 = document.getElementById("login-error-msg6");

                function validateEmail(email) {
                    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                     return re.test(email);
                }

     

                //when someone presses the login button
                $("#registration-form-submit").on('click',function(){


                    var randomNumber1 = Math.floor(Math.random() * (221 - 210) + 210);
                    var randomNumber2 = Math.floor(Math.random() * 10);
                    var randomNumber3 = Math.floor(Math.random() * 999) + 100;
                    var idRegister = randomNumber1*100000 + randomNumber2*1000 + randomNumber3;


                    loginErrorMsg.style.opacity = 0;
                    loginErrorMsg2.style.opacity = 0;
                    loginErrorMsg3.style.opacity = 0;
                    loginErrorMsg4.style.opacity = 0;
                    loginErrorMsg5.style.opacity = 0;
                    loginErrorMsg6.style.opacity = 0;
                    

                    var email = $("#email-field").val();
                    var password  = $("#password-field").val();
                    var repassword  = $("#re-password-field").val();
               
                
                    if (email == "" || email.trim() == '' || password== ""){
                         console.log("Fields cannot be blank");
                         loginErrorMsg2.style.opacity = 1;
                         
                    }
                
                    else if(!validateEmail(email))
                    {
                        console.log("email is not correct please check your @ sign and suffix/prefix");
                        loginErrorMsg3.style.opacity = 1;
                    }

                    else if(password != repassword)
                    {
                        loginErrorMsg6.style.opacity = 1;
                    }
                   
                    else if ($("#password-field").val().length < 6){
                    console.log("password should be of length 6");
                    loginErrorMsg.style.opacity = 1;
                    validated = false;
                }
                
               else{

                $.ajax(
                            {
                            url: "registration.php",
                        
                            method: 'POST',
                            data: {
                                register: 1,
                                idReg: idRegister,
                                emailPHP: email,
                                password1PHP: password,
                                password2PHP: repassword
                    
                            },
                            success: function (response) {
                            // $("#response").html(response);  
                            
                                if(response.indexOf('Success') >=0)
                                {
                                    document.getElementById("login-error-msg5").innerHTML = "You have been registered with id: " + idRegister;
                                    loginErrorMsg4.style.opacity = 0;
                                    loginErrorMsg5.style.opacity = 1;
                                  
                                }
                                else{
                                    loginErrorMsg5.style.opacity = 0;
                                    loginErrorMsg4.style.opacity = 1;
                                }
                                
                            

                            },

                            dataType: 'text'
                            }

                    
                    );
                }




                });
            });
            
        </script>
        
    </body>
</html>