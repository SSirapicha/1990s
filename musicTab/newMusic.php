<?php 

session_start();
include("../db/config.php");

$title = $_POST['title'];
$artist = $_POST['artist'];

// Song poster image
$filenamePoster = $_FILES["posterImage"]["name"];
$tempnamePoster = $_FILES["posterImage"]["tmp_name"];
$folderPoster = "./audioImg/" . $filenamePoster;

// Song
$filenameAudio = $_FILES["audio"]["name"];
$tempnameAudio = $_FILES["audio"]["tmp_name"];
$folderAudio = "./audio/" . $filenameAudio;

// Prepared statement
$stmt = $conn->prepare("INSERT INTO music (userId, title, artist, audio, poster) VALUES (?,?,?,?,?)");
$stmt->bind_param("issss", $_SESSION['userId'], $title, $artist, $filenameAudio, $filenamePoster);

// Move the uploaded files into the given folder
if (move_uploaded_file($tempnamePoster, $folderPoster) && move_uploaded_file($tempnameAudio, $folderAudio) && $stmt->execute()) {
    echo    '<script>
                alertPopup("Success!","<i>';
    echo        $title;
    echo        '</i> has been added.");
            </script>';
            
    echo '<script>document.getElementById("musicNew").style.display = "none";</script>';
} 
else {
    die(mysqli_error($conn));
}
$stmt->close();

?>