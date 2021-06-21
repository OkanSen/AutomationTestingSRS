<?php
    session_start();

    if( !isset($_SESSION['loggedIN'])) {
        header('Location: login.php');
        exit();
    }
    /*
    if (isset($_SESSION['LAST_ACTIVITY']) && isset($_SESSION['loggedIN']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3) ) {
    
        $_SESSION['Inactive'] = 1;
        session_unset();
        session_destroy();

        header('Location: login.php');
        exit();
    }*/

?>







<html lang="en">
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <link rel="stylesheet" type="text/css" href="styleSuccess.css">
      
         
    </head>
    <body>
       
        
            <div class="successbox">
                <img src="bilkent2.png" class="avatar">

                 <h1 id="success-header">Bilkent SRS</h1>

                    <div id="success-login">
                     <p id="Success_Message">You have logged in Successfully with login ID <span id="username_success">id</span></p>
                         <form id="success-form">
                        <input type="button" id="return_to_login" value="Logout">
                        </form>
                  
                    </div>
            </div>
       </form>
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous"></script>
       <script type="text/javascript">
          $(document).ready(function(){
            var x=localStorage.getItem("myid");

            document.getElementById("username_success").textContent = x; 
            $("#return_to_login").on('click',function(){
                window.location.href="logout.php";

            });

        });
        </script>
    </body>
</html>