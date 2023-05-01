<!DOCTYPE html>
<html>
<head>
<script>
function base64(s) {
	// moved to server side, see /?source
	return s
}
</script>
</head>
</body>
	<h2>Image viewer</h2>
	<p>
		Options: apple banana carrot dragonfruit elderberry flagberry
	</p>
	<form>
		<input name=name placeholder=Choose>
		<input type=submit>
	</form>
	<div id=image>
<?php
	function base64($str) {
		$s = strtolower($str);
		$ext = array("jpg", "png");
		return in_array($s, $ext)?$str:base64_encode($str);
	}

	function parse_name($str) {
		$result = "";
		for ($i = 0; $i < strlen($str); ++$i) {
			if (ord($str{$i}) === 0) {
				return implode(".", array_map("base64", explode(".", $result)));
			}
			$result .= $str{$i};
		}
		return base64_encode($result) . '.jpg';
	}

	if (isset($_GET['name']) && is_string($_GET['name'])) {
		$name = parse_name(str_replace('/', '', substr($_GET['name'], 0, 32)));
		echo '<img src="data:image/png;base64,';
		echo base64_encode(file_get_contents('../img/' . $name));
		echo '" style="max-height:640px" id="' . $name . '">';
	} else if (isset($_SERVER['HTTP_X_KEYS'])) {  // X-Keys
		if (substr(md5($_SERVER['HTTP_X_KEYS']), -6) === '123456') {
			$files = array_diff(scandir('../img'), array('.', '..'));
			echo "<ul>\n<li>".implode("</li>\n<li>",$files)."</li>\n</ul>";
		}
	} else if (isset($_GET['source'])) {
		highlight_file(__FILE__);
	}
?>
</body>
</html>
