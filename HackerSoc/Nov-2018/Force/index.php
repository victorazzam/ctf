<?php

require_once 'secret.php';

if (!empty($_SERVER['QUERY_STRING'])) {
	$query = $_SERVER['QUERY_STRING'];
	$string = parse_str($query);
	if (!empty($string['bananas'])) $page = $string['bananas'];
}

if ($page === '$_SERVER[REMOTE_ADDR]') {
	if (!empty($string['user'])) {
		$user = $string['user'];
	}
	if (!empty($string['pass'])) {
		$pass = $string['pass'];
	}
	if (!empty($user) && !empty($pass)) {
		$tmp1 = hash('sha256', $user);
		$tmp2 = hash('sha256', $pass);
		$secret = hash('sha512', $tmp1 . $tmp2 . 'apples');
	}
	echo (!empty($secret) && $secret === '6023b8f706fa7e49edd754485a2b642f493940d1') ? $_ : 'no flag for u :P';
} else {
	highlight_file(__FILE__);
}