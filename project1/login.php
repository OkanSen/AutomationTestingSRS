

<?php

session_start();

//if already logged in
if(isset($_SESSION['loggedIN'])) {
    header('Location: Success.php');
    exit();
}


    //connect php and mysqllite
    if(isset($_POST['login'])){ //everything is fine ready to login
        $connection = new mysqli('localhost','root','', 'srs');
    


        $id = $connection->real_escape_string($_POST['idPHP']);
        $password = $connection->real_escape_string($_POST['passwordPHP']);

        $sql="select * from loginform where Username ='".$id."'AND Password='".$password."'
        limit 1";

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
        <title>Login Form</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        
         
    </head>
    <body>
  
        
        <div class="loginbox">
            <img src="bilkent2.png" class="avatar">

                <h1 id="login-header">Bilkent SRS</h1>

                <div id="login-error-msg-holder">
                    <p id="login-error-msg">Invalid username <span id="error-msg-second-line">and/or password</span></p>
                    <p id="login-error-msg2">ID or Password fields cannot be blank!</p>
                    <p id="login-error-msg3">ID cannot be empty space!</p>
                    <p id="login-error-msg4">ID must be integer!</p>
                    <p id="login-error-msg5">ID must be of length 8!</p>
                    <p id="login-error-msg6">ID must be less than 40 characters!</p>
                </div>


                <form method="post" id="login-form" action="login.php">
                    <p id=id-header>Student Id</p>
                    <input type="text" name="id" id="id-field" class="login-form-field" placeholder="">
                    <p id=id-pass>Password</p>
                    <input type="password" name="password" id="password-field" class="login-form-field" placeholder="">
                    <input type="button" value="Login" id="login-form-submit">
                    <a href="registration.php" class= "ca"> Create a Bilkent account</a>
                </form>

               <!-- <p id = "response">  </p>-->

        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous"></script>
    <script type="text/javascript">
               
                const loginErrorMsg = document.getElementById("login-error-msg");
                const loginErrorMsg2 = document.getElementById("login-error-msg2");
                const loginErrorMsg3 = document.getElementById("login-error-msg3");
                const loginErrorMsg4 = document.getElementById("login-error-msg4");
                const loginErrorMsg5 = document.getElementById("login-error-msg5");
                var loginAttempts = 3;
                const loginErrorMsg6 = document.getElementById("login-error-msg6");
        $(document).ready(function(){
          
            //when someone presses the login button
            $("#login-form-submit").on('click',function(){
                var id = $("#id-field").val();
                var password  = $("#password-field").val();

                var validated = true;
                var x=localStorage.setItem("myid", id);
                loginErrorMsg.style.opacity = 0;
                loginErrorMsg2.style.opacity = 0;
                loginErrorMsg3.style.opacity = 0;
                loginErrorMsg4.style.opacity = 0;
                loginErrorMsg5.style.opacity = 0;
                loginErrorMsg6.style.opacity = 0;
                
                // WE WILL HAVE 5 TEST CASES
                //CASE 1: THE USERNAME AND PASSWORD WILL BE CORRECT
                //CASE 2: THE USERNAME AND PASSWORD WILL BE INCORRECT
                //CASE 3: THE USERNAME AND PASSWORD MUST BE LESS THAN 40 LENGTH CHAR // DONE
                //CASE 4: THE USERNAME SHOUD BE CHECKED FOR INTEGER ONLY  //DONE
                //CASE 5: THE USERNAME AND PASSWORD FIELD SHOULD NOT BE BLANK AND WHITESPACES SHOULD NOT COUNT   //          DONE

                //THIS IS CASE 5
   
                if (id == "" || id.trim() == '' || password== ""){
                console.log("ID cannot be blank");
                loginErrorMsg2.style.opacity = 1;
                validated = false;
                }

                else if (isNaN(id) == true){
                    console.log("ID must be integer");
                    loginErrorMsg4.style.opacity = 1;
                    validated = false;
                }
                else if ($("#id-field").val().length > 40 || $("#password-field").val().length > 40){
                console.log("ID or Password must be less than 40 characters");
                loginErrorMsg6.style.opacity = 1;
                validated = false;
                }

                else if ($("#id-field").val().length < 8 || $("#id-field").val().length > 8 ){
                    console.log("ID must be of length 8");
                    loginErrorMsg5.style.opacity = 1;
                    validated = false;
                }
                else{

                    $.ajax(
                    {
                        url: "login.php",
                     
                        method: 'POST',
                        data: {
                            login: 1,
                            idPHP: id,
                            passwordPHP: password
                
                        },
                        success: function (response) {
                         // $("#response").html(response);  
                        
                            if(response.indexOf('Success') >=0)
                            {
                                window.location = "Success.php";
                            }
                            else{
                                loginAttempts=loginAttempts-1;
                                alert("Login Failed Now Only "+loginAttempts+" Login Attempts Available");
                                if(loginAttempts==0)
                                {
                                    alert("No Login Attempts Available. Try again after 5 seconds");
                                    document.getElementById("id-field").disabled=true;
                                    document.getElementById("password-field").disabled=true;
                                    document.getElementById("login-form").disabled=true;
                                    document.getElementById("login-form-submit").disabled=true;
                                    setTimeout(function(){
                                    document.getElementById("id-field").disabled=false
                                    document.getElementById("password-field").disabled=false;
                                    document.getElementById("login-form").disabled=false;
                                    document.getElementById("login-form-submit").disabled=false;
                                    alert("You may try again now"); }, 5000);
                                    loginAttempts=3;
                                }
                                    loginErrorMsg.style.opacity = 1;
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