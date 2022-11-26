<?php
// establishing connection with  my database.
require_once "confir.php";

// initialishing some variables and error variables for futher coding.
$newFirstName = $newLastName = $newDate = $newMonth = $newYear = $newGamerID = $newPass = "";
$trimFirstName = $trimLastName = $trimDate = $trimMonth = $trimYear = $trimGamerID = $trimPass = $trimCPass = "";
$Name_err = $birthDay_err = $GamerID_err = $Pass_err = "";

// checking if POST request has happened....accordingly perform further tasks.
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //checking if the gamerId is empty.
    $trimGamerID = trim($_POST["gameid"]);
    if(empty($trimGamerID))
    {
      $GamerID_err = "PLEASE ENTER A GAMER-ID!";
      echo '<script> alert("PLEASE ENTER A GAMER-ID!") </script>';
    }

    else
    {
        $sql = "SELECT Sno, GAMER_ID, PASS_WORD FROM details_table WHERE GAMER_ID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_Gamer_ID);

            // set the value pf param_Gamer_ID to user defined GAMER_ID.
            $param_Gamer_ID = $trimGamerID;

            // try to execute the create statement stmt.
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)    // this checks if there exits an identical gamer-id.
                {
                  $GamerID_err = "THIS GAMER_ID HAS ALREADY BEEN TAKEN!";  //! ALERT BOX REQUIRED.
                  echo '<script> alert("THIS GAMER_ID HAS ALREADY BEEN TAKEN!") </script>';
                }
                else
                    $newGamerID = $trimGamerID;
            }
            else
            echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 28") </script>';
        }
        else
        echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 20") </script>';
    }
    mysqli_stmt_close($stmt);

    // checking if the user forgot to enter his/her first and last name.
    $trimFirstName = trim($_POST["FirstName"]);
    $trimLastName = trim($_POST["LastName"]);
    if(empty($trimFirstName)  ||  empty($trimLastName))
    {
      $Name_err = "PLEASE ENTER YOUR FIRST NAME AND LAST NAME!";
      echo '<script> alert("PLEASE ENTER YOUR FIRST NAME AND LAST NAME!") </script>';
    }

    else
    {
        $newFirstName =  $trimFirstName;
        $newLastName = $trimLastName;
    }

    // checking if the user forgot to enter his/her DATE OF BIRTH.
    $trimDate = trim($_POST["date"]);
    $trimMonth = trim($_POST["month"]);
    $trimYear = trim($_POST["year"]);
    if(empty($trimDate)  ||  empty($trimMonth)  ||  empty($trimYear))
    {
      $birthDay_err = "PLEASE ENTER THE DATE OF BIRTH CORRECTLY!";//! improvement needed for format of date
      echo '<script> alert("PLEASE ENTER THE DATE OF BIRTH CORRECTLY!") </script>';
    }
    
    else
    {
        $newDate = $trimDate;
        $newMonth = $trimMonth;
        $newYear = $trimYear;
    }

    // checking if the user has entered correct password and confirm_password.
    $trimPass = trim($_POST["pass"]);
    $trimCPass = trim($_POST["c_pass"]);
    if(empty($trimPass)  ||  empty($trimCPass))
    {
      $Pass_err = "BOTH PASSWORD AND CONFIRM_PASSWORD REQUIRED!";
      echo '<script> alert("BOTH PASSWORD AND CONFIRM_PASSWORD REQUIRED!") </script>';
    }
    
    elseif(strlen($trimPass) < 8)    //! improvement needed for strength of password. 
    {
      $Pass_err = "PASSWORD SHOULD BE ATLEAST 8 CHARACTERS LONG! AND SHOULD CONTAIN NUMERIC AND ALPHANUMERIC CAHRACTERS AND SPECIAL CHARACTERS.";
      echo '<script> alert("PASSWORD SHOULD BE ATLEAST 8 CHARACTERS LONG! AND SHOULD CONTAIN NUMERIC AND ALPHANUMERIC CAHRACTERS AND SPECIAL CHARACTERS.") </script>';
    }
    
    else
        $newPass = $trimPass;
    
    // check if the password an dconfirm_passwords are matching.
    if($trimPass != $trimCPass)
    {
      $Pass_err = "CONFIRM-PASSWORD NOT MATCHING!";
      echo '<script> alert("CONFIRM-PASSWORD NOT MATCHING!") </script>';
    }

    // Now, if we don't get any errors that means the data entered by the user is complete and correct then insert data into database.
    if(empty($Name_err)  &&  empty($GamerID_err)  &&  empty($birthDay_err)  &&  empty($Pass_err))
    {
        $sql = "INSERT INTO details_table (FIRST_NAME, LAST_NAME, DD, MM, YYYY, GAMER_ID, PASS_WORD, CONFIRM_PASSWORD) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_FirstName, $param_LastName, $param_Date, $param_Month, $param_Year, $param_GamerID, $param_Pass, $param_CPass);

            $param_FirstName = $newFirstName;
            $param_LastName = $newLastName;
            $param_Date = $newDate;
            $param_Month = $newMonth;
            $param_Year = $newYear ;
            $param_GamerID = $newGamerID ;
            $param_Pass = $newPass;
            $param_CPass = $newPass;
            // $param_Pass = password_hash($newPass, PASSWORD_DEFAULT);
            // $param_CPass = password_hash($newPass, PASSWORD_DEFAULT);

            // Now execute the stmt after it has been created
            if(mysqli_stmt_execute($stmt))
            {
              header("location: Distraction_signInPage.php");
            }
            else
            echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 98 and unable to redirect!") </script>';

          mysqli_stmt_close($stmt);
        }
        else
        echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 84") </script>';
    }
  mysqli_close($conn);
}
?>



<!doctype html>
<html>

<head>
  <link rel="stylesheet" href="Distraction_signUp.css?version=51" type = "text/css">
  <script src="https://kit.fontawesome.com/2034b17014.js" crossorigin="anonymous"></script>
  <title>Distraction|SignUp</title>
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
    <h1 id="createAccount_text"> CREATE ACCOUNT </h2>
  </div>

  <div class="complete_container_for_data_container">
    <form action = "" method = "post">
    <div class="data_container">
      <div id="fName">
        <i class="fas fa-user-edit" style="color:greenyellow;"></i>
        <!-- <i class="far fa-user" style="color: white"></i> -->
        <input type="text" name="FirstName" placeholder="FIRST NAME" id="inFName">
      </div>
      <div id="lName">
        <i class="fas fa-user-edit" style="color: greenyellow;"></i>
        <input type="text" name="LastName" placeholder="LAST NAME" id="inLName">
      </div>
      <div id="dob_container">
        <i class="fas fa-birthday-cake" style="color: greenyellow;"></i>
        <input type="number" name="date" class="dob" placeholder="DD">
        <input type="number" name="month" class="dob" placeholder="MM">
        <input type="number" name="year" class="dob" placeholder="YYYY">
      </div>
      <div id="gamerId_container">
        <i class="fas fa-user-tag" style="color: greenyellow;"></i>
        <input type="text" name="gameid" placeholder="GAMER-ID  eg: dark_Knight">
      </div>
      <div id="password_container">
        <i class="fas fa-key" style="user-select: auto; color: greenyellow;"></i>
        <input type="password" name = "pass" placeholder="PASSWORD">
      </div>
      <div id="confirmPassword_container">
        <i class="fas fa-key" style="user-select: auto; color: greenyellow;"></i>
        <input type="password" name = "c_pass" placeholder="CONFIRM-PASSWORD">
      </div>
    </div>
    <button class = "button1" id = "signIn_button" type = "submit">
      <h4> SIGN UP </h4>
    </button>
      <!-- <a href = "Distraction_HomePage.html"><button class = "button1" id = "signIn_button" type = "button">
      <h4> SIGN UP </h4>
      </button></a> -->
    </form>

    <a href = "Distraction_signInPage.php">
      <h5 id = "member"> ALREADY A MEMBER?</h5>
    </a>
  </div>

</body>

</html>