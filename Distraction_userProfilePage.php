<?php
    require_once "confir.php";
    session_start();
    $trimSuggestion = $suggeston_err = "";
    $inputRating = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // this if is not common for all the webpages made before because it performs a different task every time it gets a POST request for the server. So, it's task here is to check which rating button is selected. 
        if(isset($_POST['rating_choice1'])) // this means that rating button 1 is pressed.
        {
            $inputRating = "5 star";
        }
        if(isset($_POST['rating_choice2'])) // this means that rating button 2 is pressed
        {
            $inputRating = "4 star";
        }
        if(isset($_POST['rating_choice3'])) // this means that rating button 3 is pressed
        {
            $inputRating = "3 star";
        }
        if(isset($_POST['rating_choice4'])) // this means that rating button 4 is pressed
        {
            $inputRating = "2 star";
        }
        if(isset($_POST['rating_choice5'])) // this means that the reamining button that is thefifth button is pressed
        {
            $inputRating = "1 star";
        }

        if(!empty($inputRating)) // if this if condition is true then it would confirm that the user has given a post request for rating not for suggestion
        {
            $sql = "SELECT Sno, GAMER_ID, RATING FROM distraction_suggestions_table WHERE GAMER_ID = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if($stmt)  // if the statement is prepared then execute the following task
            {
                mysqli_stmt_bind_param($stmt, "s", $param_gamerID);
                $param_gamerID = $_SESSION['gamerid'];
                if(mysqli_stmt_execute($stmt))  // execute the created stmt
                {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) >= 1)    // this means that the user had given a post request earlier as well, it may be for suggestion or for rating.
                    {
                        $sql = "UPDATE distraction_suggestions_table SET RATING = ? WHERE GAMER_ID = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        if($stmt) // if the statement is prepared then execute the following task
                        {
                            mysqli_stmt_bind_param($stmt,"ss", $param_RATING, $param_gamerID);
                            $param_gamerID = $_SESSION['gamerid'];
                            $param_RATING = $inputRating;
                            if(mysqli_stmt_execute($stmt))  //execute the created stmt
                            {
                                echo '<script> alert("WE HAVE SUCCESSFULLY RECORDED THE RATING, THANK YOU!!")</script>';
                                header("loaction: Distraction_userProfilePage.php");
                            }
                            else
                            {
                                echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 42")</script>';
                            }
                            // mysqli_stmt_close($stmt);
                        }
                        else
                        {
                            echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 37") </script>';
                        }
                        // mysqli_close($conn);
                    }
                    else // this means it is first time when the user is submitting the rating and has also not given suggestion.
                    {
                        $sql = "INSERT INTO distraction_suggestions_table (FIRST_NAME, LAST_NAME, GAMER_ID, RATING) VALUE (?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);
                        if($stmt)  // if the statement is prepared then execute the following task
                        {
                            mysqli_stmt_bind_param($stmt, "ssss", $param_first_name, $param_last_name, $param_gamer_id, $param_rating);
                            $param_first_name = $_SESSION['user_FIRST_NAME'];
                            $param_last_name = $_SESSION['user_LAST_NAME'];
                            $param_gamer_id =  $_SESSION['gamerid']; 
                            $param_rating = $inputRating;
                            if(mysqli_stmt_execute($stmt))
                            {
                                echo '<script> alert("WE HAVE SUCCESSFULLY RECORDED THE RATING, THANK YOU!!")</script>';
                                header("location: Distraction_userProfilePage.php");
                            }
                            else
                            {
                                echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 66")</script>';
                            }
                            // mysqli_stmt_close($stmt);
                        }   
                        else
                        {
                            echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 59") </script>';
                        }
                        // mysqli_close($conn);
                    }
                }
                else
                {
                    echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 30")</script>';
                }
                mysqli_stmt_close($stmt);
            }
            else
            {
                echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 26") </script>';
            }
            mysqli_close($conn);
            $_POST = array();
            $inputRating = "";
        }

        else
        {
            $trimSuggestion = trim($_POST['suggestion_input']);
            if(empty($trimSuggestion))
            {
                $suggestion_err = "PLEASE ENTER A SUGGESTION IN ORDER TO SUBMIT";
                echo '<script> alert("PLEASE ENTER A SUGGESTION IN ORDER TO SUBMIT")</script>';
            }
        
            // if we find no errors then execute the following statements.
            if(empty($suggestion_err))
            {
                $sql = "INSERT INTO distraction_suggestions_table (FIRST_NAME, LAST_NAME, GAMER_ID, SUGGESTION) VALUE (?,?,?,?)";
                // prepare the statement stmt
                $stmt = mysqli_prepare($conn, $sql);
                // if the stmt is prepared then excute the following statements
                if($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "ssss", $param_FIRST_NAME, $param_LAST_NAME, $param_GAMER_ID, $param_SUGGESTION);
                    // for accessing the first name, last nameand other details of the user we have start a SESSION.
                    //session_start();
                    $param_FIRST_NAME = $_SESSION['user_FIRST_NAME'];
                    $param_LAST_NAME = $_SESSION['user_LAST_NAME'];
                    $param_GAMER_ID =  $_SESSION['gamerid']; 
                    $param_SUGGESTION = $trimSuggestion;
                    // after binding all the parameters excute the statement stmt.
                    if(mysqli_stmt_execute($stmt))
                    {
                        echo '<script> alert("WE HAVE SUCCESSFULLY RECORDED YOUR SUGGESTION(S), THANK YOU!!")</script>';
                        header ("location: Distraction_userProfilePage.php");
                    }
                    else // in case if the stmt execution fails
                    {
                        echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 32")</script>';
                    }
                    mysqli_stmt_close($stmt);
                }
                else
                {
                    echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 21") </script>';
                }
                mysqli_close($conn);
            }
            else
            {
                echo '<script> alert("UNKNOWN ERROR INTERRUPTION: LINE:: 15")</script>';
            }
        }
    }
?>


<!DOCTYPE html>
<html>

<head>
    <title>PROFILE@Distraction</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Explora&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akronim&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Distraction_userProfilePage.css" type = "text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Stick+No+Bills:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="Distraction_HomePage.php"> HOME </a></li>
            <li><a href="Distraction_AboutPage.php"> ABOUT </a></li>
            <li><a href="#"> PROFILE </a></li>
            <li><a href="logout.php"> LOGOUT </a></li>
        </ul>
        <div id = "welcome_text_for_user">
            <img src = "Distraction_homePage_User.png" alt = "image display failure" width = "30px" height = "30px" style = "position: relative; top: 15px; left: 668px;">
            <h4 style = "position: relative; top: -42px; left: 703px; width: 70px; height: 30px; color: whitesmoke; font-family:'Times New Roman', Times, serif; font-weight: bold;"><?php echo "Hi! " . $_SESSION['gamerid'] ?></h4>
        </div>   
    </div>

    <div class="container1">
        <div class="container2">
            <h1 id="heading"> MY PROFILE</h1>
            <h2 id="subheading"> "A BETTER VERSION OF ME"
            </h2>
        </div>
    </div>

    <div class = "box">
        <div class = "flying_square" style = "--i:0"></div>
        <div class = "flying_square" style = "--i:1"></div>
        <div class = "flying_square" style = "--i:2"></div>
        <div class = "flying_square" style = "--i:3"></div>
        <div class = "flying_square" style = "--i:4"></div>
        <div class = "flying_square" style = "--i:5"></div>
        <div class = "flying_square" style = "--i:6"></div>
        <div class = "flying_square" style = "--i:7"></div>
        <div class = "flying_square" style = "--i:8"></div>
    </div>

    <div class = "hexagon">
        <div class="hexagon-inner">
            <div class="hexagon-inner-in">
            </div>
        </div>
    </div>

    <div class = "container_for_userData">
        <div class = "conn_all_userData_components">
            <label for = "User_name" style = "color:  #d5dbdb;">NAME:</label>
            <div class = "info_div" id = "user_name_div">
               <h5> <?php echo $_SESSION['user_FIRST_NAME'] . " " . $_SESSION['user_LAST_NAME'] ?> </h5>
            </div>
            <label for = "User_birthday" style = "color:  #d5dbdb;">DATE OF BIRTH:</label>
            <div class = "info_div" id = "user_birthday_div">
               <h5> <?php echo $_SESSION['user_DD'] . "/" . $_SESSION['user_MM'] . "/" . $_SESSION['user_YYYY'] ?> </h5>
            </div>
            <label for = "User_gamerid" style = "color:  #d5dbdb;">GAMER-ID:</label>
            <div class = "info_div" id = "user_gamerid_div">
               <h5> <?php echo $_SESSION['gamerid'] ?> </h5>
            </div>
            <label for = "User_password" style = "color:  #d5dbdb;">PASSWORD:</label>
            <div class = "info_div" id = "user_password_div">
               <h5> <?php echo $_SESSION["user_PASS_WORD"] ?> </h5>
            </div>
            <label for = "lastPlay_info" style = "color:  #9B0000;">RECENT PLAY:</label>
            <div class = "info_div" id = "last_play_info_div">
               <h5>
                   <?php
                        if(isset($_SESSION["recent_play"]))
                        {
                            echo $_SESSION["recent_play"];
                        }
                        else
                        {
                            echo "NO ACCOUNT";
                        }
                   ?> 
               </h5>
            </div>
        </div>
    </div>    

    <h1 id = "rating_heading_text"> RATE US ? </h1>
    <form action = "" method = "post">
        <div class = "rating">
            <input type = "submit" name = "rating_choice1" class = "rating_icon" id = "icon1">
            <label for = "icon1">
            <!-- icon for loved it -->
            <img src = "Distraction_UserProfile_rating_LovedIt.png" alt = "failed to display an image" width = "190px" height = "190px">
            <h2 id = "rating_tag1">LOVED IT</h2>
            </label>

            <input type = "submit" name = "rating_choice2" class = "rating_icon" id = "icon2">
            <label for = "icon2">
            <!-- icon for liked it -->
            <img src = "Distraction_UserProfile_rating_LikedIt.png" alt = "failed to display an image" width = "190px" height = "190px">
            <h2 id = "rating_tag2">LIKED IT</h2>
            </label>

            <input type = "submit" name = "rating_choice3" class = "rating_icon" id = "icon3">
            <label for = "icon3">
            <!-- icon for it's ok -->
            <img src = "Distraction_UserProfile_rating_It'sOk.png" alt = "failed to display an image" width = "190px" height = "190px">
            <h2 id = "rating_tag3">IT'S OK</h2>
            </label>

            <input type = "submit" name = "rating_choice4" class = "rating_icon" id = "icon4">
            <label for = "icon4">
            <!-- icon for dislik it -->
            <img src = "Distraction_UserProfile_rating_DislikeIt.png" alt = "failed to display an image" width = "190px" height = "190px">
            <h2 id = "rating_tag4">DISLIKE IT</h2>
            </label>

            <input type = "submit" name = "rating_choice5" class = "rating_icon" id = "icon5">
            <label for = "icon5">
            <!-- icon for hated it -->
            <img src = "Distraction_UserProfile_rating_HatedIt.png" alt = "failed to display an image" width = "190px" height = "190px">
            <h2 id = "rating_tag5">HATED IT</h2>
            </label>
        </div>
    </form>

    <div class="login_form_container">
        <h1> SUGGESTIONS </h1>
        <div>
            <h3> YOUR SUGGESTION MEAN A  <span> GEM TO US </span></h3>
        </div>
        <form action="" class="login_form" method = "post">
            <div class = "suggestion_box">
                <input type = "text" name = "suggestion_input" id = "for_suggestions" placeholder = "Please keep it Short">
                <button type = "submit" id = "submit_suggestion">SUBMIT</button>
            </div>
        </form>
    </div>

    <div id="end">

        <h6 id="endH"> info@DISTRACTED.com </h6>
        <hr width="100%">
        <div class="img1"><a href="#"> <img src="search.png" height="70px"
        weidth="70px" alt="can't load image"> </a></div>
        <div class="img1"><a href="#"> <img
        src="facebook.png" height="70px" weidth="70px" alt="can't load image"> </a></div>
        <div class="img1"><a href="#"> <img
        src="instagram.png" height="70px" weidth="70px" alt="can't load image"> </a></div>
        <div class="img1"><a href="#"> <img
        src="twitter.png" height="70px" weidth="70px" alt="can't load image"> </a></div>
        <div class="img1"><a href="#"> <img
        src="whatsapp.png" height="70px" weidth="70px" alt="can't load image"> </a></div>
        <div class="img1"><a href="#"> <img
        src="telegram.png" height="70px" weidth="70px" alt="can't load image"> </a></div>
    </div>
</body>

</html>