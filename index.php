<?php

session_start();
// Start session and check if user is logged in
if ($_SESSION['userId']) {
    include ("./db/config.php");

    // Header table
    $query = "SELECT img1, img2, img3, statusMsg, emoji FROM header WHERE userId =". $_SESSION['userId'];
    $result = mysqli_query($conn, $query);
    $header = mysqli_fetch_assoc($result);

    // Login table
    $query = "SELECT username FROM login WHERE userId =". $_SESSION['userId'];
    $result = mysqli_query($conn, $query);
    $login = mysqli_fetch_assoc($result);
}
else {
    session_destroy();
    // Redirect user to login page if not logged in
    header("Location: login/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>welcome, <?php echo $login['username']; ?></title>
    <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1">
    
    <!-- 90's font , VT323 ; 'font-family: 'VT323', monospace;' -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

    <!-- Symbol -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!-- Css, JavaScript, jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Alert notification -->
    <div id="alert" class="alertContainer" style="display:none;">
        <div id="alertType" style="float:left; color:#2b542c;"></div>
        <div id="alertDesc" style="float:left; color:#3c763d; margin-left:5px;"></div>
    </div>

    <!-- Header text, status & image slideshow -->
    <header>
        <div id="headerContainer" class="headerContainer">
            <!-- Header text -->
            <div class="headerText">
                <h2>
                    Welcome, <?php echo $login['username']; ?><br>
                    
                    <!-- Update status bar message by clicking outside of the bar or press enter -->
                    <input type="text" class="statusBar" id="statusMsg" name="statusMsg" onchange="statusMsgUpdate()" placeholder='Enter status message...' value="<?php error_reporting(E_ALL ^ E_WARNING); echo $header['statusMsg']; ?>" maxlength="45">
                </h2>
            </div>

            <!-- Image slideshow -->
            <div id="slideContainer">
                <div class="slideShowImg fade">
                    <img src="./headerTab/headerImg/<?php echo $header['img1']; ?>" width="500" height="100">
                </div>
                <div class="slideShowImg fade">
                    <img src="./headerTab/headerImg/<?php echo $header['img2']; ?>" width="500" height="100">
                </div>
                <div class="slideShowImg fade">
                    <img src="./headerTab/headerImg/<?php echo $header['img3']; ?>" width="500" height="100">
                </div>
            </div>
        </div>
    </header>

    <section>
        <!-- Horizontal navigation bar with logout and username button, emoji, and song -->
        <div class="horNavBar">
            <!-- Logout & username button -->
            <div class="logout">
                <button onclick="location.href='./login/logout.php'">Logout</button>
            </div>
            <div class="username">
                <button><?php echo $login['username']; ?></button>
            </div>

            <!-- Display emoji input from header -->
            <div id="displayHorNavEmoji" style="float:right; padding-right:6px; padding-top:3px; font-size:12px;"><?php echo $header['emoji']; ?></div>
            
            <!-- Display current song playing -->
            <div style="float:left; padding-left:41px; padding-top:5px; font-size:13px;">
                Now Playing:<div id="displayCurrSong" style="float:right; padding-left:5px;">--</div>
            </div>
        </div>

        <!-- Vertical navigation bar -->
        <div id="verNavBar" class="verNavBar">
            <button onclick="navContent('headerNav')">&#128252 Header</button><br>
            <button onclick="navContent('seriesNav'); 
                    document.getElementById('seriesList').style.display='block';">&#127916 Series</button><br>
            <button onclick="navContent('musicNav')
                    document.getElementById('musicList').style.display='block';">🎸 Music</button><br>
        </div>

        <?php include("headerTab/header.php") ?>
        <?php include("musicTab/music.php") ?>
        <?php include("seriesTab/series.php") ?>
    </section>

    <script>
        function alertPopup(type, desc) {
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertType").innerHTML = type;
            document.getElementById("alertDesc").innerHTML = desc;

            // Close alert in 5 sec
            setTimeout(function() {
                document.getElementById("alert").style.display = "none";
            },5000);
        }
        
        // Display content from vertical navigation
        function navContent(navName) {
            var i, navNone, seriesNone, musicNone;
        
            // Display none from vertical navigation
            navNone = document.getElementsByClassName("navContent");
            // Display none from series navigation
            seriesNone = document.getElementsByClassName("seriesContent");
            // Display none from music navigation
            musicNone = document.getElementsByClassName("musicContent");

            for (i = 0; i < navNone.length; i++) {
                navNone[i].style.display = "none";
            }
            for (i = 0; i < seriesNone.length; i++) {
                seriesNone[i].style.display = "none";
            }
            for (i = 0; i < musicNone.length; i++) {
                musicNone[i].style.display = "none";
            }
            // Display selected vertical navigation content
            document.getElementById(navName).style.display = "block";
        }

        // Display content from series
        function seriesContent(navName) {
            var i, seriesNone;

            // Display none from series navigation
            seriesNone = document.getElementsByClassName("seriesContent");
            for (i = 0; i < seriesNone.length; i++) {
                seriesNone[i].style.display = "none";
            }
            // Display selected series content
            document.getElementById(navName).style.display = "block";
        }

        // Display content from music
        function musicContent(navName) {
            var i, musicNone;
            // Display none from music navigation
            musicNone = document.getElementsByClassName("musicContent");
            for (i = 0; i < musicNone.length; i++) {
                musicNone[i].style.display = "none";
            }
            // Display selected music content
            document.getElementById(navName).style.display = "block";
        }

        /* 
        // Display content from php file to div html
        function displayContent(htmlDiv, phpFile) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById(htmlDiv).innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", phpFile, true);
            xhttp.send();
        }
        displayContent("displaySeries", "displaySeries.php");
        displayContent("displayMusic", "displayMusic.php");
        $('#displaySeries').load('displaySeries.php');
        */

        // Display slideshow images
        let slideIndex = 0;
        displaySlideShow();
        function displaySlideShow() {
            let i;
            let slides = document.getElementsByClassName("slideShowImg");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) { 
                slideIndex = 1 
            }    
            slides[slideIndex-1].style.display = "block";  
            setTimeout(displaySlideShow, 5000);
        }
    </script>
</body>
</html>