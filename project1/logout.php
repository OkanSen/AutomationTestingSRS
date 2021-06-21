<?php
    session_start();

    unset($_SESSIOn['loggedIN']);
    session_destroy();
    header('Location: login.php');
    exit();
?>