<?php
    // estabilish connection with the database.

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'DisTrac2021Tion');
    // define('DB_PASSWORD', 'AnSh@2002');  for localhost phpmyadmin
    define('DB_NAME', 'sign_up');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conn == false)
    {
        echo '<script> alert("Error: Connection can not be established")</script>';
        dir("Error: Connection can not be established");
    }
?>