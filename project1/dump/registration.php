<?php
    session_start();
    
        //connect php and mysqllite
        if(isset($_POST['register'])){ //everything is fine ready to register
            $connection = new mysqli('localhost','root','', 'srs');
        
            
            $randomNumber1 = rand(210,221);
            $randomNumber2 = rand(0,9);
            $randomNumber3 = rand(100,999);
            $randomid = $randomNumber1*100000 + $randomNumber2*1000 + $randomNumber3;

            //$id = $connection->real_escape_string($_POST['idPHP']);
            $email = $connection->real_escape_string($_POST['emailPHP']);
            $password = $connection->real_escape_string($_POST['passwordPHP']);
    
            $sql = "insert into loginform  VALUES ($randomid, $password, $email)";
    
            $result = mysqli_query($connection, $sql);
            
            if(mysqli_num_rows($result)!=0){
            $_SESSION['loggedIN'] = 1;
            $_SESSION['id'] = $id;
                exit("Success");
            }
    
            else{
            
                exit("Failure");
            }
            
    
        }
?>







<html lang="en">
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Form</title>
        <link rel="stylesheet" type="text/css" href="registration_style.css">
        
         
    </head>
    <body>
  
        
        <div class="loginbox">
            <img src="bilkent2.png" class="avatar">

                <h1 id="login-header">Bilkent Sign-up </h1>

                <div id="login-error-msg-holder">
                    <p id="login-error-msg">Invalid username <span id="error-msg-second-line">and/or password</span></p>
                    <p id="login-error-msg2">Any field cannot be blank!</p>
                    <p id="login-error-msg3">Email is fucked up!</p>
                    <p id="login-error-msg4">ID must be integer!</p>
                    <p id="login-error-msg5">ID must be of length 8!</p>
                    <p id="login-error-msg6">ID must be less than 40 characters!</p>
                </div>


                <form method="post" id="login-form" action="login.php">
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

                    //loginErrorMsg.style.opacity = 0;
                    loginErrorMsg2.style.opacity = 0;
                    loginErrorMsg3.style.opacity = 0;
                    //loginErrorMsg4.style.opacity = 0;
                    //loginErrorMsg5.style.opacity = 0;
                    //loginErrorMsg6.style.opacity = 0;


                    var email = $("#email-field").val();
                    var password  = $("#password-field").val();
                    var repassword  = $("#re-password-field").val();
               
                
                    if (email == "" || email.trim() == '' || password== ""){
                         console.log("Fields cannot be blank");
                         loginErrorMsg2.style.opacity = 1;
                         
                }

                else if(validateEmail(email))
                {
                    console.log("email is all right")
                    loginErrorMsg3.style.opacity = 0;

                    $.ajax(
                       {
                           url: "register.php",

                           method: 'POST',

                           data
                       } 
                    );

                    

                }
                
                else if(!validateEmail(email))
                {
                    console.log("email is not valid");
                    loginErrorMsg3.style.opacity = 1;
                }

            });





            });
            
        </script>
        
    </body>
</html>