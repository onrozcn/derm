<?php
require_once('../source/settings.php');

$firmId = $_POST['firmId'];
$message = '';
$result = 'fail';

if (!isset($firmId) || empty($firmId)) {
	$result = 'fail';
	$message = '<div class="alert alert-danger m-alert m-alert--air m-alert--outline animated shake" role="alert"><strong><i class="fa fa-thumbs-o-down"></i></strong> Firma seçimi yapılamadı.</div>';
}
else {
	if (isset($_SESSION['userid'])) {
		$user = GetSingleDataFromTable('users', $_SESSION['userid']);
		$userFirmList = GetUserFirmPermissions($user['firmpermissions']);
		if (isset($userFirmList[$firmId]) && $userFirmList[$firmId] > 0) {
			$_SESSION['selectedFirm'] = $firmId;
			UpdateTable2('users', array('lastselectedfirmid'), array($firmId), 'id', $_SESSION['userid']);
			$result = 'ok';
			$message = '<div class="alert alert-success m-alert m-alert--air m-alert--outline animated fadeIn" role="alert"><strong><i class="fal fa-fingerprint"></i> Giriş başarılı, </strong>yönlendiriliyorsunuz...</div>';
		}
		else {
			$result = 'fail';
			$message = '<div class="alert alert-danger m-alert m-alert--air m-alert--outline animated shake" role="alert"><strong><i class="fa fa-thumbs-o-down"></i></strong> Bu firmayı seçme yetkiniz bulunmamaktadır.</div>';
		}
	}
	else {
		$result = 'fail';
		$message = '<div class="alert alert-danger m-alert m-alert--air m-alert--outline animated shake" role="alert"><strong><i class="fa fa-thumbs-o-down"></i></strong> Oturum açılamadı. Sayfayı yenileyip tekrar giriş yapmayı deneyin.</div>';
	}
}

if ($result != 'ok') {
	LogOut();
}

echo json_encode(array('result' => $result, 'message' => $message));
