<?php 

session_start();
include("config.php");

$type = $_POST['type'];

// Delete series
if ($type == 1) {
    $id = $_POST['val'];

    // Prepared statement
    $stmt = $conn->prepare("DELETE from series WHERE userId = ? AND id = ?");
    $stmt->bind_param("ii", $_SESSION['userId'], $id);

    if ($stmt->execute()) {
        echo '<script>alert("Successfully Deleted!")</script>';
        echo '<script>seriesContent("seriesList"); $("#seriesList").load(" #seriesDisplay");</script>';
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

// Edit series
else if ($type == 2) {
    $id = $_POST['val'];

    $title = $_POST['editTitle'];
    $yearReleased = $_POST['editYearReleased'];
    $country = $_POST['editCountry'];
    $notes = $_POST['editNotes'];
    $type = $_POST['editType'];

    // Prepared statement
    $stmt = $conn->prepare("UPDATE series SET title = ?, yearReleased = ?, type = ?, country = ?, notes = ? WHERE userId = ? AND id = ?");
    $stmt->bind_param("sisssii", $title, $yearReleased, $type, $country, $notes, $_SESSION['userId'], $id);
    
    if ($stmt->execute()) {
        echo '<script>alert("Successfully Saved!")</script>';
        echo '<script>seriesContent("seriesList"); $("#seriesList").load(" #seriesDisplay");</script>';
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

?>