<?php

###############
## Functions ##
###############

function _die($msg) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
	header('Status: 403 Forbidden');
	$_SERVER['REDIRECT_STATUS'] = 403;
	die("<p><h3 style=color:red>$msg</h3></p>");
}

function blacked($cidr, $ip) {
	list($prefix, $mask) = explode("/", $cidr);
	return 0 === (((ip2long($ip) ^ ip2long($prefix)) >> $mask) << $mask);
}

function get_mimetype($url) {
	$buffer = file_get_contents($url);
	$finfo = new finfo(FILEINFO_MIME_TYPE);
	return $finfo->buffer($buffer);
}

function curl($url, $agt) {
	$options = [
		CURLOPT_URL            => $url,   # requested url
		CURLOPT_RETURNTRANSFER => true,   # return all data
		CURLOPT_BINARYTRANSFER => true,   # raw data
		CURLOPT_HEADER         => false,  # only data
		CURLOPT_USERAGENT      => $agt,   # user-agent header
		CURLOPT_FOLLOWLOCATION => true    # follow redirects
	];

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$raw = curl_exec($ch);
	curl_close($ch);

	return $raw;
}


###################
## Parse request ##
###################

if (empty($_REQUEST['url'])) die(file_get_contents("index.html"));

$agt = empty($_REQUEST['agt']) ? 'curl' : $_REQUEST['agt']; # User-Agent
$url = urldecode($_REQUEST['url']); # scheme://host:port/path
$parsed = parse_url($url);

if (array_key_exists("host", $parsed) === false) _die("You must supply a valid URL");

$host = $parsed["host"];


#################
## Filter host ##
#################

if (filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
	$ip = $host;
} else {
	$ip = dns_get_record($host, DNS_A);
	if (count($ip) > 0) {
		$ip = $ip[0]["ip"];
	} else if (count($ip) > 1) {
		$ip = $ip[1]["ip"];
        } else	{
		_die("URL did not resolve");
	}
}

$banned = ["127.0.0.1/24", "169.254.0.0/16", "0.0.0.0/8"];

foreach ($banned as $cidr) {
	if (blacked($cidr, $ip)) {
		_die("IP range is blacklisted ({$cidr})");
	}
}


#######################
## Allow only images ##
#######################

$mimetypes = ['image/png','image/jpg','image/jpeg','image/gif'];
$mime = get_mimetype($url);

if (stripos($mime, 'image/') === false) {
	_die("Not a valid image file");
}


#######################
## Return the result ##
#######################

header("Content-type: " . $mime);
print(curl($url, $agt));
