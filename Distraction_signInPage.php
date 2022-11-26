<?php
// this will handle all th login tasks;
    session_start();

    // this if statement is used to check if the user is currently logged in and is trying to re-login.
    if(isset($_SESSION['gameid']))
    {
        header("location: Distraction_HomePage.php");
        exit;
    }

    // Now the task to validate the user begins...
    require_once "confir.php";

    $trimgamerID = $trimPass = "";
    $gamerID = $Pass = $err = "";

    // checking if the user has called for a POST (data) operation to be performed.
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $trimgamerID = trim($_POST['gameid']);
      $trimPass = trim($_POST['pass']);
        if(empty($trimgamerID)  ||  empty($trimPass))
        {
          $err = "PLEASE ENTER YOUR GAMER_ID AND PASSWORD CORRECTLY!";
          echo '<script> alert("PLEASE ENTER YOUR GAMER_ID AND PASSWORD CORRECTLY!") </script>';
        }
        
        else
        {
          $gamerID = $trimgamerID;
          $Pass = $trimPass;
        }

       if(empty($err))
       {
            // if this entered gamerID exists in database then check if the password entered is correct or not
            $sql = "SELECT Sno, FIRST_NAME, LAST_NAME, DD, MM, YYYY, GAMER_ID, PASS_WORD, ENTRY_TIME FROM details_table WHERE GAMER_ID = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if($stmt)
            {
                mysqli_stmt_bind_param($stmt, "s", $param_gamerID);
                $param_gamerID = $gamerID;

                // try to execute the stmt
                if(mysqli_stmt_execute($stmt))
                {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {
                        mysqli_stmt_bind_result($stmt, $sno, $user_first_name, $user_last_name, $user_dd, $user_MM, $user_YYYY, $gamerID, $db_Pass, $user_entry_time);

                        if(mysqli_stmt_fetch($stmt))
                        {
                            if($Pass == $db_Pass)
                            {
                                // if the password is autheticated then allow the user to login.
                                session_start();
                                $_SESSION["Sno"] = $sno;
                                $_SESSION["user_FIRST_NAME"] = $user_first_name;
                                $_SESSION["user_LAST_NAME"] = $user_last_name;
                                $_SESSION["user_DD"] = $user_dd;
                                $_SESSION["user_MM"] = $user_MM;
                                $_SESSION["user_YYYY"] = $user_YYYY;
                                $_SESSION["user_ENTRY_TIME"] = $user_entry_time;
                                $_SESSION["gamerid"] = $gamerID;
                                $_SESSION["user_PASS_WORD"] = $db_Pass;
                                $_SESSION["loggedIn"] = true;
                                // redirects the user to home page of DISTRACTION.
                                header("location: Distraction_HomePage.php");   
                            }
                            else
                            echo '<script> alert("INCORRECT PASSWORD") </script>';
                        }
                        else
                        echo '<script> alert("UNABLE TO TRANSFER DATA FROM COLUMNS TO VARIABLES IN LINE : 50") </script>';
                    }
                    else
                    echo '<script> alert("INVALID GAMER-ID OR PASSWORD!") </script>';
                }
                else
                echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 41") </script>';
              // mysqli_stmt_close($stmt);
            }
            else
            echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 35") </script>';
       }
      // mysqli_close($conn);
    }
?>



<!doctype html>
<html>

<head>
  <link rel="stylesheet" href="Distraction_signIn.css?version=51" type = "text/css">
  <script src="https://kit.fontawesome.com/2034b17014.js" crossorigin="anonymous"></script>
  <title>Distraction|SignIn</title>
</head>

<body>
  <div id="wallpaper" class="wallpaper_container">
    <img id="background" src="pexels-lucie-liz-3165335.jpg" alt="can't display the image" width="1345px" height="647px">
  </div>
  <div id="wallpaper_for_signUp_form" class="form_background">
    <img id="signUp_form_wallpaper" src="pexels-anni-roenkae-4793467.jpg" alt="can't display the image" width="710px"
      height="646px">
  </div>

  <div id = "for_display_label" class = "container_for_display_label">
    <h1 id = "welcome_to_distraction">
      <span>WELCOME</span> <span>TO</span> <span>DISTRACTION</span>
    </h1>
  </div>

  <div class="complete_container_for_signUp"> </div>
  <div>
    <h1 id="createAccount_text"> SIGN IN </h2>
  </div>

  <div class="complete_container_for_data_container">
    <form action = "" method = "post">
    <div class="data_container">
      <!-- <div id="fName">
        <i class="fas fa-user-edit" style="color:greenyellow;"></i>
        <!-- <i class="far fa-user" style="color: white"></i> -->
        <!-- <input type="text" name="FirstName" placeholder="FIRST NAME" id="inFName">
      </div>  -->
      <!-- <div id="lName">
        <i class="fas fa-user-edit" style="color: greenyellow;"></i>
        <input type="text" name="LastName" placeholder="LAST NAME" id="inLName">
      </div> -->
      <!-- <div id="dob_container">
        <i class="fas fa-birthday-cake" style="color: greenyellow;"></i>
        <input type="number" name="date" class="dob" placeholder="DD">
        <input type="number" name="month" class="dob" placeholder="MM">
        <input type="number" name="year" class="dob" placeholder="YYYY">
      </div> -->
      <div id="gamerId_container">
        <i class="fas fa-user-tag" style="color: greenyellow;"></i>
        <input type="text" name="gameid" placeholder="GAMER-ID">
      </div>
      <div id="password_container">
        <i class="fas fa-key" style="user-select: auto; color: greenyellow;"></i>
        <input type="password" name = "pass" placeholder="PASSWORD">
      </div>
      <!-- <div id="confirmPassword_container">
        <i class="fas fa-key" style="user-select: auto; color: greenyellow;"></i>
        <input type="password" placeholder="CONFIRM-PASSWORD">
      </div> -->
    </div>
    <button class = "button1" id = "signIn_button" type = "submit">
      <h4> LET'S GO </h4>
    </button>
      <!-- <a href = "Distraction_HomePage.html"><button class = "button1" id = "signIn_button" type = "button">
        <h4> LET'S GO </h4>
      </button></a> -->
    </form>
  </div>

</body>

</html>