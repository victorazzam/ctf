<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Access</title>
  <style>
body{
  background: #000;
  padding-top: 10px;
}
p {
  color: lime;
  font-family: "Courier";
  font-size: 20px;
  margin: 10px 0 0 10px;
  white-space: nowrap;
  overflow: hidden;
  width: 50em;
  animation: type 4s steps(100, end)
}
p:nth-child(2) {animation: type2 8s steps(60, end)}
p a {
  color: lime;
  text-decoration: none;
}
span {animation: blink 1s infinite}
@keyframes type {from {width: 0}}
@keyframes type2 {
  0% {width: 0}
  50% {width: 0}
  100% {width: 100}
}
@keyframes blink {to{opacity:.0}}
::selection {background:black}
  </style>
</head>
<body>
<!-- Design taken from https://codepen.io/rusjames/pen/uAFhE -->
<?php
$a = '<p>Only agent <b><u>James Bond 007</u></b> can read the secret contents of this page.<span>|</span></p>';
$b = '<p>Welcome back, agent <b><u>James Bond 007</u>!</b><br><br>As promised, we have kept your secret safe for you.<br>flag{us3r_4gent_1s_n0t_5ecure}<span>|</span></p>';
echo $_SERVER['HTTP_USER_AGENT'] == 'James Bond 007' ? $b : $a;
?>
</body>
</html>