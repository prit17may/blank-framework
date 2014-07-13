<?php

session_start();
ob_start();
//header('x-frame-options: DENY');
define('root', str_replace('\\', '/', getcwd()) . '/');
require_once root . 'include/functions.php';
require_once root . 'include/db_functions.php';

require_once root . 'include/url_defines.php';
require_once root . '/include/db_defines.php';
require_once root . 'include/controller.php';
if (isset($_GET['logout'])) {
	if (cookie_exists()) {
		cookie_delete();
	}
	session_destroy();
	header("Location: " . base_url());
	exit;
}

//call the controller class
$config = array(
		'database_type' => database_type,
		'database_name' => database_name,
		'server' => server,
		'username' => username,
		'password' => password
);
$obj = new Controller($config);

$database = $obj->_db;
$obj->_data['obj'] = $obj;
$obj->_data['database'] = $database;
$vars = array();
if (isset($_GET['vars']) && $_GET['vars']) {
	$vars = $_GET['vars'];
	get_vars($vars);
}
$obj->_data['vars'] = $vars;

$without_hf = array(
		'ajax',
		'login'
);

if (isset($vars) && !empty($vars) && $vars[1]) {
	if (!session_exists() && !in_array($vars[1], $without_hf)) {
		header("Location: " . base_url('login'));
		exit;
	}
	$obj->module($vars[1]);
} elseif (!session_exists()) {
	header("Location: " . base_url("login"));
	exit;
} else
	$obj->module('index');
ob_flush();
