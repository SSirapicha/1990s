<?php 

session_start();
include("../db/config.php");

$type = $_POST['type'];

// Update status message
if ($type == 1) {
    $statusMsg = $_POST['val'];

    // Prepared statement
    $stmt = $conn->prepare("UPDATE header SET statusMsg = ? WHERE userId =". $_SESSION['userId']);
    $stmt->bind_param("s", $statusMsg);

    if ($stmt->execute()) {
        echo $statusMsg;  
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

// Update emoji
else if ($type == 2) {
    $navEmoji = $_POST['val'];

    // Prepared statement
    $stmt = $conn->prepare("UPDATE header SET emoji = ? WHERE userId =". $_SESSION['userId']);
    $stmt->bind_param("s", $navEmoji);

    if ($stmt->execute()) {
        echo $navEmoji;  
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

// Update header images
else if ($_FILES["headerImg1"]["name"]) {
    // Get uploaded header image
    $filename = $_FILES["headerImg1"]["name"];
    $tempname = $_FILES["headerImg1"]["tmp_name"];
    $folder = "./headerImg/" . $filename;

    // Prepared statement
    $stmt = $conn->prepare("UPDATE header SET img1 = ? WHERE userId =". $_SESSION['userId']);
    $stmt->bind_param("s", $filename);

    // Move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder) && $stmt->execute()) {
        echo '<script>alertPopup("Success!", "<i>Header 1</i> has been updated.");</script>';  
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

else if ($_FILES["headerImg2"]["name"]) {
    $filename = $_FILES["headerImg2"]["name"];
    $tempname = $_FILES["headerImg2"]["tmp_name"];
    $folder = "./headerImg/" . $filename;

    // Prepared statement
    $stmt = $conn->prepare("UPDATE header SET img2 = ? WHERE userId =". $_SESSION['userId']);
    $stmt->bind_param("s", $filename);

    if (move_uploaded_file($tempname, $folder) && $stmt->execute()) {
        echo '<script>alertPopup("Success!", "<i>Header 2</i> has been updated.");</script>';  
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}

else if ($_FILES["headerImg3"]["name"]) {
    $filename = $_FILES["headerImg3"]["name"];
    $tempname = $_FILES["headerImg3"]["tmp_name"];
    $folder = "./headerImg/" . $filename;

    // Prepared statement
    $stmt = $conn->prepare("UPDATE header SET img3 = ? WHERE userId =". $_SESSION['userId']);
    $stmt->bind_param("s", $filename);

    if (move_uploaded_file($tempname, $folder) && $stmt->execute()) {
        echo '<script>alertPopup("Success!", "<i>Header 3</i> has been updated.");</script>';  
    } 
    else {
        die(mysqli_error($conn));
    }
    $stmt->close();
}
 
?>