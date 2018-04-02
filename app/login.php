<?php
    session_name("PHPSESSID");
    session_start();

    if(isset($_SESSION['username'])){
        header("location: app.php");
    }
    //absolute server path $_SERVER['DOCUMENT_ROOT']
    include("./built/scripts/login/authenticate.php");

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- initial-scale=.95 -->
	<link rel="stylesheet" type="text/css" href="./built/css/vendor.css"> 
	<link rel="stylesheet" type="text/css" href="./built/css/default.css"> 

<title>MH Login</title>
</head>
<body id="login">

    <section class="animated">
        <span class="spanLogo"></span>
        <h3>MH Hotels</h3>
        <h1>Mehran</h1>
        <h6>Hotel Booking System</h6>

        <form style="text-align:center;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <!-- USERNAME -->
            <div class="controls input-group input-group-md">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"></span>
                </span>
                <input name="username" class="form-control" type="text" placeholder="Username" value="<?php echo $username; ?>" require>
            </div>

            <!-- PASSWORD -->
            <div class="controls input-group input-group-md">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-lock"></span>
                </span>
                <input name="password" class="form-control" type="password" placeholder="Password" require>
            </div>
 
            <!-- SUBMIT BUTTON -->
            <button name="submit" type="submit" class="btn btn-primary btn-md btn-block">Sign in</button>
            
            <!-- ERROR DISPLAY -->
            <span class="err"><?php echo $errorDisplayed; ?></span>

            <!-- SIGN UP BUTTON -->
            <a href="register.php">Sign up</a>
        </form>

    </section>

</body>
</html>
