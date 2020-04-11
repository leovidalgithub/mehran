<?php
session_name("PHPSESSID");
session_start();

include("./built/scripts/login/registersign.php");

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

<body id="register">
	<section class="animated">
		<span class="spanLogo"></span>
		<h3>MH Hotels</h3>

		<form style="text-align:center;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

			<!-- USERNAME -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-user"></span>
				</span>
				<input name="username" class="form-control" type="text" placeholder="Username" value="<?php echo $username; ?>" require>
			</div>

			<!-- FULL NAME -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-tag"></span>
				</span>
				<input name="fullname" class="form-control" type="text" placeholder="Full name" require>
			</div>

			<!-- ADDRESS -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-plane"></span>
				</span>
				<input name="address" class="form-control" type="text" placeholder="Address">
			</div>

			<!-- PHONE -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-phone-alt"></span>
				</span>
				<input name="phone" class="form-control" type="text" placeholder="Phone">
			</div>

			<!-- EMAIL -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-envelope"></span>
				</span>
				<input name="email" class="form-control" type="text" placeholder="email" require>
			</div>

			<!-- USERS TYPE -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-th-list"></span>
				</span>
				<select name="usertype">
					<?php
					foreach ($usersType as $row) {
						$value = $row['id'];
						$type = $row['type'];
						echo "<option value=$value"; if ($value == 1) echo ' selected'; echo ">$type</option>";
					}
					?>
				</select>
			</div>

			<!-- NEW PASSWORD -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-lock"></span>
				</span>
				<input name="newpassword" class="form-control" type="password" placeholder="New password" require>
			</div>

			<!-- REPEAT PASSWORD -->
			<div class="controls input-group input-group-md">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-lock"></span>
				</span>
				<input name="repeatpassword" class="form-control" type="password" placeholder="Repeat password" require>
			</div>

			<!-- SUBMIT BUTTON -->
			<button name="btn_register" type="submit" class="btn btn-primary btn-md btn-block">Register</button>
			<!-- ERROR DISPLAY -->
			<span class="err"><?php echo $errorDisplayed; ?></span>
			<!-- TO LOGIN BUTTON -->
			<a href="login.php">Login</a>
		</form>

	</section>

</body>

</html>