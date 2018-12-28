<html>
<head>
<title>Birthday Invitees Info</title>
</head>
<body>
	<form method="post">
		<label for="name">Name of invitee:</label>
		<input type="text" name="name">
		<input type="submit" value="Search">
	</form>
	<pre style="white-space:pre-line">
	<?php
if (!isset($_POST["name"]) || !is_string($_POST["name"]) || empty($_POST["name"])) {exit;}
$query = strtolower($_POST["name"]);
if (strpos($query, ";") !== false) {die("Error eW91IGNhbid0IHJ1biBtdWx0aXBsZSBxdWVyaWVzIGF0IG9uY2UK");}

$pdo = new PDO("sqlite:superdb.sqlite3");
$stmt = $pdo->prepare("SELECT * FROM invitations WHERE name LIKE '%$query%';");
if (!$stmt) {die("No data.");}
$stmt->execute();
$results = $stmt->fetchAll();
if (empty($results)) {die("No data.");}
echo "<table style='text-align:left'><tr><th>Name</th><th>Age</th></tr>";
foreach ($results as $r) {echo "<tr><td>" . $r[0] . "</td><td>" . $r[1] . "</td></tr>";}
echo "</table>";
// Solution:
// SELECT * FROM invitations WHERE name LIKE '%     a' UNION SELECT * FROM wildcard --     %'
	?>
	</pre>
</body>
</html>