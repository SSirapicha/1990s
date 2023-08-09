<?php 

session_start();
include("config.php");

// login.php
if (isset($_POST['login-submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Prepared statement
        $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // If username exists, check password
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            // If password is correct, log in
            if ($data['password'] == $password) {
                $_SESSION['userId'] = $data['userId'];
                header("Location: index.php?login=successful"); 
            }
            else {
                header("Location: login.php?login=fail,username-and-password-do-not-match"); 
            } 
        }
        else {
            header("Location: login.php?login=fail,username-does-not-exist"); 
        } 
        $stmt->close();
    }
    else {
        header("Location: login.php?login=fail,missing-field");
    }
}

// signup.php
else if (isset($_POST['signup-submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Check if username already existed
        $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // If username exists, cannot signup
        if ($result->num_rows > 0) {
            header("Location: signup.php?signup=fail,username-already-existed");
        }
        else {
            // Prepared statement
            $stmtInsert = $conn->prepare("INSERT INTO login (username, password) VALUES (?,?)");
            $stmtInsert->bind_param("ss", $username, $password);
        
            if ($stmtInsert->execute()) {
                // Get 'userId' from user that signup to insert into tables with foreign key
                $stmtGetUserId = $conn->prepare("SELECT userId from login WHERE username = ?");
                $stmtGetUserId->bind_param("s", $username);
                $stmtGetUserId->execute();

                $getUserId = $stmtGetUserId->get_result();
                $data = $getUserId->fetch_assoc();
                $userId = $data['userId']; // userId

                $stmtHeader = $conn->prepare("INSERT INTO header (userId) VALUES (?)");
                $stmtHeader->bind_param("s", $userId);
                $stmtHeader->execute();
                $stmtHeader->close();

                /*$stmtSeries = $conn->prepare("INSERT INTO series (userId) VALUES (?)");
                $stmtSeries->bind_param("s", $userId);
                $stmtSeries->execute();
                $stmtSeries->close();

                $stmtMusic = $conn->prepare("INSERT INTO music (userId) VALUES (?)");
                $stmtMusic->bind_param("s", $userId);
                $stmtMusic->execute();
                $stmtMusic->close();*/

                $stmtGetUserId->close();
                header("Location: login.php?signup=successful");
            }
            else { 
                header("Location: signup.php?signup=fail");
            } 
            $stmtInsert->close();
        }
        $stmt->close();
    }
    else {
        header("Location: signup.php?signup=fail,missing-field");
    }
}

?>