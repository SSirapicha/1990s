<?php 

session_start();
include("config.php");

$title = $_POST['title'];
$yearReleased = $_POST['yearReleased'];
$country = $_POST['country'];
$notes = $_POST['notes'];
$type = $_POST['type'];

// Series poster image
$filename = $_FILES["posterImage"]["name"];
$tempname = $_FILES["posterImage"]["tmp_name"];
$folder = "./image/" . $filename;

// Prepared statement
$stmt = $conn->prepare("INSERT INTO series (userId, title, yearReleased, type, country, notes, poster) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("isissss", $_SESSION['userId'], $title, $yearReleased, $type, $country, $notes, $filename);

// Move the uploaded image into the folder 'image'
if (move_uploaded_file($tempname, $folder) && $stmt->execute()) {
    echo '<script>alert("Successfully Saved!")</script>';
} 
else {
    die(mysqli_error($conn));
}
$stmt->close();

?>