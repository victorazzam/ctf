<?php
$title = "Login";
if (!empty($_POST["user"])) {
	$title = "Home";
	$user = $_POST["user"];
	setcookie("admin", "false", time() + 86400, "/");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<style>
body {
	font-family: sans-serif;
}
main {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}
form {font-family:monospace}
	</style>
</head>
<body>
<main>
<?php
	if ($title == "Home") {
		if ($_COOKIE["admin"] == "true") {
			echo "<div>CTF{p00r-4uthentic4ti0n-a6eb734f}</div>";
		} else {
			echo "<div>Hi, $user!<br>You're not authorised to see the flag.</div>";
		}
	} else {
		echo '<h1>Login</h1>
	<div><form action method="post">
		Username: <input type="text" name="user"><br><br>
		Password: <input type="password" name="pass"><br><br>
		<input type="submit" value="OK" style="width: 100%">
	</form></div>';
	}
?>
</main>
</body>
</html>