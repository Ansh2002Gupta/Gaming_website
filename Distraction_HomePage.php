<?php
 // check if the user is currently-correctly-active-login.
    session_start();
    if(!isset($_SESSION['loggedIn'])  ||  $_SESSION['loggedIn'] != true)
    {
        header("location: Distraction_signInPage.php");
        exit;
    }

    require_once "confir.php";

    $trimSuggestion = $suggeston_err = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_POST['game_1']))
        {
            $_SESSION["recent_play"] = "SUPER MARIO";
            header("location: https://supermarioplay.com/fullscreen");
        }
        elseif(isset($_POST['game_2']))
        {
            $_SESSION["recent_play"] = "CHESS";
            header ("location: https://lichess.org/");
        }
        elseif(isset($_POST['game_3']))
        {
            $_SESSION["recent_play"] = "TAKKEN";
            header ("location: https://www.retrogames.cc/psx-games/tekken-3.html");
        }
        else    // if there is nothing in recent_game_play variable then do the post request is for suggestion only.
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
                    // session_start();
                    $param_FIRST_NAME = $_SESSION['user_FIRST_NAME'];
                    $param_LAST_NAME = $_SESSION['user_LAST_NAME'];
                    $param_GAMER_ID =  $_SESSION['gamerid']; 
                    $param_SUGGESTION = $trimSuggestion;
                    // after binding all the parameters excute the statement stmt.
                    if(mysqli_stmt_execute($stmt))
                    {
                        echo '<script> alert("WE HAVE SUCCESSFULLY RECORDED YOUR SUGGESTION(S), THANK YOU!!")</script>';
                        header ("location: Distraction_HomePage.php");
                    }
                    else // in case if the stmt execution fails
                    echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 30")</script>';
                    mysqli_stmt_close($stmt);
                }
                else
                echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 30") </script>';
                mysqli_close($conn);
            }
            else
            echo '<script> alert("UNKNOWN ERROR INTERRUPTION: LINE:: 24")</script>';
        }
    }
?>


<!DOCTYPE html>
<html>

<head>
    <title>DISTRACTIONS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Explora&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akronim&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Distraction_HomePage.css?version=51" type = "text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Stick+No+Bills:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="#"> HOME </a></li>
            <li><a href="Distraction_AboutPage.php"> ABOUT </a></li>
            <li><a href="Distraction_userProfilePage.php"> PROFILE </a></li>
            <li><a href="logout.php"> LOGOUT </a></li>
        </ul>
        <div id = "welcome_text_for_user">
            <img src = "Distraction_homePage_User.png" alt = "image display failure" width = "30px" height = "30px" style = "position: relative; top: 15px; left: 668px;">
            <h4 style = "position: relative; top: -42px; left: 703px; width: 70px; height: 30px; color: whitesmoke; font-family:'Times New Roman', Times, serif; font-weight: bold;"><?php echo "Hi! " . $_SESSION['gamerid'] ?></h4>
        </div>    
    </div>

    <div class="container1">
        <div class="container2">
            <h1 id="heading"> DISTRACTIONS </h1>
            <h2 id="subheading"> DIVE DEEP INTO THE WORLD OF GAMING
            </h2>
        </div>
    </div>
    <img id="logo" src="webpage2 logo.jpg" alt="no image">
    <div class="container_for_logo_material">
        <h3> ABOUT US </h3>
        <p> Hello Readers! This is team Distraction. We have brought to you this wonderful website that intends to bring to you the best of the gaming experience. Now, you might be thinking that we have lot of these kinds of website in today's internet world, then why you should consider ours. The answer is in front of you, we have brought to you the latest of games that are being released in the gaming world and that to free of cost. We, promise to bring these kind of games ahead as well. Now, it's our turn to expect something from you. Don't worry, it's not your bank details, just kidding, we just want you to enjoy our games to the fullest, explore our website, stay connected with us and if you like or attempt towards bringing happiness to this society through gaming,  then do share our website with others. THANK YOU!</p>
    </div>

    <form action = "" method = "post">
        <div class="container_for_game_menu">
            <div>
                <h2> LET'S PLAY!!! </h2>
            </div>
            
            <div class = "button_box" style = "position: relative; width: 50px; height: 50px; z-index: 4; background-color: transparent; border: none; user-select: auto;">
                <button class = "play_now_button" id = "play_now_button1" type = "submit" name = "game_1"> PLAY NOW </button>
            </div> 
            <label for = "game_img_1">
                <img src="Mario_unsplash.jpg" alt="can't display image 1">
            </label>
        
            <div class = "button_box" style = "position: relative; width: 50px; height: 50px; z-index: 4; background-color: transparent; border: none; user-select: auto;">
                <button class = "play_now_button" id = "play_now_button2" type = "submit" name = "game_2"> PLAY NOW </button>
            </div>

            <!-- <button class = "play_now_button" type = "submit" name = "game_2"> PLAY NOW </button> -->

            <label for = "game_img_2">
            <!-- <iframe src="https://www.retrogames.cc/embed/40238-tekken-3.html" width="600px" height="450px" frameborder="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" scrolling="no"></iframe> -->
            <img src="chess.jpg" alt="can't display image 2">
            </label>
        
            <!-- <input type = "submit" name = "game_3"> -->
            <div class = "button_box" style = "position: relative; width: 50px; height: 50px; z-index: 4; background-color: transparent; border: none; user-select: auto;">
            <button class = "play_now_button" id = "play_now_button3" type = "submit" name = "game_3"> PLAY NOW </button>
            </div>
            <!-- <button class = "play_now_button" type = "submit" name = "game_3"> PLAY NOW </button> -->
            <label for = "game_img_3">
            <img src="takken.png" alt="can't display image 3">
            </label>
        </div> 
    </form>

    <div class="squad_img_container">
        <button class="roster_click" type="button" onclick="location.href = 'Distraction_AboutPage.php';">
        <h1>ROSTER</h1>
        </button>
    </div>

    <div class="view_roster">
        <p> We Created It Together </p>
    </div>

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
            <!-- <div>
                <label for="username"> USERNAME </label>
                <input type="text" placeholder="DARK_KNIGHT">
            </div>

            <div>
                <label for="password"> PASSWORD </label>
                <input type="password">
            </div> -->
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