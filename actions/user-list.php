<?php 
require_once('../source/settings.php');
if (!isset($_SESSION['logged'])) {
	header('location:' . $siteUrl . 'index.php');
	die();
}
if (isset($_GET['Action'])) {
	$action = $_GET['Action'];
}
else {
	header('location:' . $siteUrl . 'index.php');
	die();
}

if ($action == 'DeleteUser') {
	DeleteUser(isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0);
}

function DeleteUser($id)
{
	if (empty($id)) {
		JsonResult('empty', 'Please fill in all required fields', $id);
	}
	else {
		if (DeleteById('users', 'id', $id, false)) {
			JsonResult('ok', 'User profile deleted', $id);
		}
		else {
			JsonResult('fail', 'An error occurred while delete process', $id);
		}
	}
}

if ($action == 'inactiveUser') {
	InactiveUser(isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0);
}

function InactiveUser($id)
{
	if (empty($id)) {
		JsonResult('empty', 'Please fill in all required fields', $id);
	}
	else {
		if (UpdateTable2('users', array('active'), array('0'), 'id', $id)) {
			JsonResult('ok', 'User profile inactiveted', $id);
		}
		else {
			JsonResult('fail', 'An error occurred while delete process', $id);
		}
	}
}

if ($action == 'activeUser') {
	ActiveUser(isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0);
}

function ActiveUser($id)
{
	if (empty($id)) {
		JsonResult('empty', 'Please fill in all required fields', $id);
	}
	else {
		if (UpdateTable2('users', array('active'), array('1'), 'id', $id)) {
			JsonResult('ok', 'User profile activated', $id);
		}
		else {
			JsonResult('fail', 'An error occurred while delete process', $id);
		}
	}
}