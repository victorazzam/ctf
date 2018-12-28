<?php
	function getUserIP()
	{
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];
	if(filter_var($client, FILTER_VALIDATE_IP))
		{ return $client; }
	elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{ $ip = $forward; }
	else
		{ return $remote; }
	}
	$ip = getUserIP();
?>
<!DOCTYPE html>
<html>
<head>
	<title>IP</title>
	<style>
body {
	background: #000;
	color: #fff;
	font-family: sans-serif;
}
main {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}
a {
	color: lightblue;
	text-decoration: none;
}
a:hover {text-decoration:underline}
pre {font-size:26pt}
	</style>
</head>
<body>
<main>
	<h1>IP</h1>
	<div>
		<p>
			I know who you are. This is your IP.
		</p>
	</div>
	<pre><?php echo $ip; ?></pre>
	<div>
		<p>
			Does that <a href="../scare.html">scare</a> you? I bet it does.
			<br><br>
			Now be gone!
		</p>
	</div>
</main>
</body>
</html>