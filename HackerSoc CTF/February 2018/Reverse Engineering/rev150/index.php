<html>
<head>
<title>Birthday Invitees Info</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300:800" type="text/css">
<style>
main {
	width: 60%;
	margin: 0 auto;
	display: flex;
	text-align: center;
	flex-direction: column;
	font-family: "Open Sans", sans-serif;
}
th {
	width: 1%;
	font-weight: 800;
	border-bottom-width: 2px;
}
tr * {padding: 10px}
body {
	width: 100wh;
	height: 90vh;
	color: #fff;
	background: linear-gradient(-45deg, #EE7752, #E73C7E, #23A6D5, #23D5AB);
	background-size: 400% 400%;
	-webkit-animation: Gradient 15s ease infinite;
	-moz-animation: Gradient 15s ease infinite;
	animation: Gradient 15s ease infinite;
}
@-webkit-keyframes Gradient {
	0% {background-position: 0% 50%}
	50% {background-position: 100% 50%}
	100% {background-position: 0% 50%}
}
@-moz-keyframes Gradient {
	0% {background-position: 0% 50%}
	50% {background-position: 100% 50%}
	100% {background-position: 0% 50%}
}
@keyframes Gradient {
	0% {background-position: 0% 50%}
	50% {background-position: 100% 50%}
	100% {background-position: 0% 50%}
}
</style>
</head>
<body>
<!-- Design taken from https://codepen.io/P1N2O/pen/pyBNzX -->
<main>
	<h2>Ice Cream Sales Logs</h2>
	<?php
$hash = (empty($_GET["hash"]) || !is_string($_GET["hash"])) ? "q": $_GET["hash"];
$time = (empty($_GET["time"]) || !is_string($_GET["time"])) ? "q": $_GET["time"];
$flav = array(hash("sha256", "chocolate")=>"Chocolate", hash("sha256", "vanilla")=>"Vanilla");
if (strlen($hash) != 64 || strlen($time) != 10 || !array_key_exists($hash, $flav) || !ctype_digit($time) || $time > 1519219800 || strpos($time, "0") === 0)
{
	die("<p>No data.</p>");
}
echo "<table border='2' style='border:1px solid #000;text-align:left;border-collapse:collapse'>
	<tr>
		<th>Customer</th>
		<th>Flavour</th>
		<th>Price</th>
		<th>Date</th>
	</tr>
";
if ($hash === "7499aced43869b27f505701e4edc737f0cc346add1240d4ba86fbfa251e0fc35" && $time === "1489757820")
{
	echo "	<tr>
		<td>Ovuvuevuevue Enyetuenwuevue Ugbemugbem Osas</td>
		<td>Chocolate</td>
		<td>&#8776; &euro;3.50</td>
		<td>2017-03-17 13:37:00</td>
	<tr>
</table>\n";
	exit;
}
$C = array("Waylon Dalton", "Justine Henderson", "Marcus Cruz", "Thalia Cobb", "Mathias Little", "Eddie Randolph", "Angela Walker", "Juan Collins", "Sabrina Chan", "Sidney Goodwin", "Kenna Maldonado", "Scarlet Hill", "Carita Futrell", "Mahalia Portis", "Cathey Alderson", "Rosaria Edmonds", "Alberto Dubinsky", "Lorrie Gritton", "Georgia Rippel", "Rosalyn Pugsley", "Solange Meli", "Lonna Clancy", "Moon Hemsley", "Olga Deshazo", "Kaci Pottinger", "Alida Smalley", "Kermit Deblasio", "Gema Ladue", "Mia Laffoon", "Shalonda Rahimi", "Beverlee Moudy", "Linnea Alford");
$P = array("0.99", "1.00", "1.50", "1.99", "2.00", "2.50", "2.99", "3.00", "3.50", "3.99", "4.00", "4.50", "4.99", "5.00");
$flavour = $flav[$hash];
$date = gmdate("Y-m-d H:i:s", $time);
$rand = random_int(2, 6);
for ($i = 0; $i <= $rand; $i++)
{
	$customer = $C[array_rand($C)];
	$price = $P[array_rand($P)];
	echo "	<tr>
		<td>$customer</td>
		<td>$flavour</td>
		<td>$price</td>
		<td>$date</td>
	</tr>\n";
}
echo "</table>\n";
?>
</main>
</body>
</html>