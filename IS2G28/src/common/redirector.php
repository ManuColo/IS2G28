<?php
require_once substr(__DIR__,0,-11).'/config/config.php';
session_start();
if (isset($_SESSION) && isset($_SESSION['referer'])) {
	$url = $cfg->wwwRoot . "/src/". $_SESSION['referer'];
} else {
	$url = $cfg->wwwRoot . "/src/";
}
header("location:".$url);