<?php

$head = "frontend/html/head.html";
$auth = "frontend/html/auth.html";
$bot = "frontend/html/bot.html";
$main = "frontend/html/main_page.html";
$html = file_get_contents($head);
if (isset($_COOKIE['user']) && $_COOKIE['user']) {
	$html .= file_get_contents($main);
}
else {
	$html .= file_get_contents($auth);
}
$html .= file_get_contents($bot);

print($html);