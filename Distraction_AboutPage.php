<?php
    require_once "confir.php";
    session_start();
    $trimSuggestion = $suggeston_err = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
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
                    header ("location: Distraction_AboutPage.php");
                }
                else // in case if the stmt execution fails
                echo '<script> alert("FAILED TO EXECUTE: mysqli_stmt_execute($stmt) in line 31")</script>';
                mysqli_stmt_close($stmt);
            }
            else
            echo '<script> alert("FAILED TO CREATE stmt: $stmt in line 21") </script>';
            mysqli_close($conn);
        }
        else
        echo '<script> alert("UNKNOWN ERROR INTERRUPTION: LINE:: 15")</script>';
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>ABOUTUS@Distraction</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Explora&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akronim&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Distraction_AboutPage.css" type = "text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Stick+No+Bills:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="Distraction_HomePage.php"> HOME </a></li>
            <li><a href="#"> ABOUT </a></li>
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
            <h1 id="heading"> ROSTER </h1>
            <h2 id="subheading"> "None of us is as smart as all of us"
            </h2>
        </div>
    </div>

    <!--FOR ANSH(begin)-->
    <!-- <img id="ImageOfAnsh" src="webpage2 logo.jpg" alt="no image"> -->
    <img id="ImageOfAnsh" src="Ansh.jpg" alt="no image">
    <div class="divForAnsh">
        <h3 id="forAnsh"> ANSH GUPTA </h3>
        <p id="materialAboutPerson"> Hi Guys! This is Ansh, team-leader. My team and I have worked day and night so as to bring to you the best of the gaming experience. I worked in Front as well as the Backend of this website. The Front end part included the designing and the layout of the website that you see in front of you, are some of my attempts; while on the Backend I worked with Atul so as to set up a remote server from where our user will be able to access this website and get the best experience of this website through a user friendly interface. We, don't expect much from our user, except for being loyal and our regular customer. If, you like the effort put in by my team then please a humble request, do share this website with your friends. Let's enjoy gaming.</p>
    </div>

    <!--FOR ANSH(end)-->

    <!--FOR ATUL(begin)-->

    <img id="ImageOfAtul" src="webpage2 logo.jpg" alt="no image">
    <div class="divForAtul">
        <h3 id="forAtul"> ATUL SINGH CHAUHAN </h3>
        <p id="materialAboutPerson"> Hello Friends! I am Atul. Less to say, more to show;this is my moto. I worked on the networking, photography, and coordination side to bring this website come to play. On the networking side, I along with my team-mate Ansh, deployed the website to a VIRTUAL PRIVATE SERVER (VPS) and brought the website to the world-wide-web. The photos that you see on this website are some of my efforts, hope you like them. It was my job to coordinate the information conveyed by the leader to each member of the group. Guys! literally you can never understand the effort that we have put in to build this website so it's my personal request to show your love towards it.</p>
    </div>

    <!--FOR ATUL(end)-->

    <!--FOR ABHIGYAAN(begin)-->

    <img id="ImageOfAbhigyaan" src="webpage2 logo.jpg" alt="no image">
    <div class="divForAbhigyaan">
        <h3 id="forAbhigyaan"> ABHIGYAN MISHRA </h3>
        <p id="materialAboutPerson"> Bravo world! we did it, actually they did it, yes! my team-mates, they have being brilliant through out this developing journey. While, I slept, they used to work and work full night, this made me wonder to make some contribution into this website, but I want to accept that inspite of continuous alerts from my leader I was busy watching <a href = "https://en.wikipedia.org/wiki/Anime">ANIME</a>, I apologize for this, sorry everyone. But, here's a big message for you all guys, even if world leaves your hand, never leave your faith on whatever you are doing. Keep Calm and just finish it of.</p>
    </div>

    <!--FOR ABHIGYAAN(end)-->

    <!--FOR ABHAY(begin)-->

    <!-- <img id="ImageOfAbhay" src="webpage2 logo.jpg" alt="no image"> -->
    <img id="ImageOfAbhay" src="Abhay.jpg" alt="no image">
    <div class="divForAbhay">
        <h3 id="forAbhay"> ABHAY GARG </h3>
        <p id="materialAboutPerson"> Hi guys! This is Abhay Garg. I wanna share with you the history of this website, that is how we got the idea to develop this website. So, the story is, and it is a real story, we were given a task to develop a mini-project by our college. The project could be on anything, but it should be related to computer science and should portray the world's latest technologies. Keeping all these things in our mind we got an idea to develop a website that would bring an earthquake in this big world of gaming. I know I have exaggerated a lot but, it is destined that one day we all would really bring this to a reality. Bless us people! thanks for reading.</p>
    </div>

    <!--FOR ABHAY(end)-->

    <!--FOR ANKIT(begin)-->

    <!-- <img id="ImageOfAnkit" src="webpage2 logo.jpg" alt="no image"> -->
    <img id="ImageOfAnkit" src="Ankit_C.png" alt="no image">
    <div class="divForAnkit">
        <h3 id="forAnkit"> ANKIT CHAUHAN </h3>
        <p id="materialAboutPerson"> I know you might be tired of reading all this long. So, to keep it in a nutshell, I just want to say that, efforts yield you result one day or the other, so just keep faith on yourself and obviously on us, because we would never let you down. As said by all of us, this is the place where you can get releived from all days stress and get distracted by the lastest top trending games that we'll bring forth in the coming days. Just keep calm and wait. And, yes if you are thinking about my role in this project, them I would say it was little but important. This was to advertise this website on to different social media platforms like Instagram, Facebook, Twitter etc. Even you can directly connect to us and have a talk through our Whatsapp connection. Concluding here, thanks.</p>
    </div>
    <!--FOR ANKIT(end)-->

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