<?php 

session_start();
include("../db/config.php");

$type = $_POST['type'];

// Delete series
if ($type == 1) {
    $id = $_POST['val'];

    // Prepared statement to get the title of series to be deleted for alert info
    $stmtGetTitle = $conn->prepare("SELECT title from series WHERE userId = ? AND id = ?");
    $stmtGetTitle->bind_param("ii", $_SESSION['userId'], $id);
    $stmtGetTitle->execute();

    $getTitle = $stmtGetTitle->get_result();
    $data = $getTitle ->fetch_assoc();
    $title = $data['title']; // title to be deleted

    $stmtGetTitle->close();

    // Prepared statement
    $stmt = $conn->prepare("DELETE from series WHERE userId = ? AND id = ?");
    $stmt->bind_param("ii", $_SESSION['userId'], $id);

    if ($stmt->execute()) {
        echo    '<script>
                    alertPopup("Success!","<i>';
        echo        $title;
        echo        '</i> has been deleted.");

                    seriesContent("seriesList"); 
                    $("#seriesList").load(" #seriesDisplay");
                </script>';
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
        echo    '<script>
                    alertPopup("Success!","<i>';
        echo        $title;
        echo        '</i> has been updated.");

                    seriesContent("seriesList"); 
                    $("#seriesList").load(" #seriesDisplay");
                </script>';
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

?>