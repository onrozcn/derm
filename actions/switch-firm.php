<?php
require_once('../source/settings.php');

$firmId = $_POST['firmId'];
$message = '';
$result = 'fail';

if (!isset($firmId) || empty($firmId)) {
	ToastrJsonResult('fail', 0, 'error', 'Hata', 'Firma seçimi yapılamadı');
}
else {
	if (isset($_SESSION['userid'])) {
		$user = GetSingleDataFromTable('users', $_SESSION['userid']);
		$userFirmList = GetUserFirmPermissions($user['firmpermissions']);
		if (isset($userFirmList[$firmId]) && $userFirmList[$firmId] > 0) {
			$_SESSION['selectedFirm'] = $firmId;
			UpdateTable2('users', array('lastselectedfirmid'), array($firmId), 'id', $CurrentUser['id']);
			ToastrJsonResult('ok', $firmId, 'success', 'Başarılı', 'Firma değiştirildi. Lütfen bekleyin...');
		}
		else {
			ToastrJsonResult('fail', $firmId, 'error', 'Hata', 'Bu firmayı seçme yetkiniz bulunmamaktadır');
		}
	}
	else {
		ToastrJsonResult('fail', $firmId, 'error', 'Hata', 'Oturum açılamadı. Sayfayı yenileyip tekrar giriş yapmayı deneyin');
	}
}
