<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

<style>
    * {
        font-family: 'VT323', monospace; 
        background-color: #fff8e5;
        cursor: default;
    }
    
    form {
        text-align: center;
        position: absolute;
        top: 45%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        border-style: solid;
        border-width: 2px;
        padding: 5px 20px;
        background-color: pink;
    }

    input[type='text'], input[type='password'] { 
        border-style: none;
        margin-bottom: 5px;
        padding: 2px;
        cursor: pointer;
    }

    input[type='text']:focus, input[type='password']:focus { 
        outline: none !important;
    }

    input[type='submit'] { 
        margin-top: 15px;
        margin-bottom: 5px;
        border-style: solid;
        border-width: 1px;
        border-radius: 2px;
        cursor: pointer;
    }
</style>
</head>

<body>
	<form method="post" action="authorizeLogin.php">
        <p style="background:inherit">Log In<p>
        <div style="background:pink">
            <label for="username" style="background:pink">Username:</label>
            <input type="text" id="username" name="username"><br>

            <label for="password" style="background:pink">Password:</label>
            <input type="password" id="password" name="password"><br>
  		
		    <input type="submit" name="login-submit" value="Login">
        </div>
	</form> 
    <a style="float:right; margin-right:10px; color:blue; cursor:pointer;" href="signup.php">Sign Up</a>
</body>
</html>