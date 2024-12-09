<?php
require_once('../source/settings.php');

$k_adi = $_POST['username'];
$k_pass = $_POST['password'];
$message = '';
$result = 'fail';
$firmList = array();

if (!isset($k_adi) || empty($k_adi) || !isset($k_pass) || empty($k_pass)) {
	$result = 'fail';
	$message = '<div class="alert alert-danger" role="alert">
																<div class="alert-icon"><i class="fa fa-door-open kt-icon-sm"></i></div>
																<div class="alert-text">A simple danger alert—check it out!</div>
															</div>';
}
else {
	if (UserLogin($k_adi, $k_pass) == 1) {
		$user = GetSingleDataFromTable('users', $_SESSION['userid']);
		$userFirmList = GetUserFirmList($user['firmpermissions']);

		if(count($userFirmList)<=0){
			//admin ise tüm firmaları aktar.
			$CurrentUser['permissions'] = GetUserPermissions($user['permissions']);

			if (checkPermission(array('superadmin', 'admin'))) {
				$allPermissions = GetListDataFromTable($firmParamTableName, '*', 'id');
				$post['firmPermission'] = array();
				foreach ($allPermissions as $permission) {
					$post['firmPermission'][] = $permission['id'];
				}
				$selectedPermissions = SetUserFirmPermissions($post);
				if(UpdateTable2('users', array('firmpermissions'), array($selectedPermissions), 'username', $k_adi)){
					$user = GetSingleDataFromTable('users', $_SESSION['userid']);
					$userFirmList = GetUserFirmList($user['firmpermissions']);
				}
			}
		}

		foreach ($userFirmList as $uf) {
			if ($uf['active'] == 1) {
				$firmList[] = array(
					'id'    => $uf['id'],
					'tag'   => $uf['tag'],
					'logo'   => $uf['logo'],
					'unvan' => $uf['unvan']
				);
			}
		}
		if (count($firmList) <= 0) {
			$result = 'fail';
			$message = '<div class="alert alert-warning m-alert m-alert--air m-alert--outline animated shake" role="alert"><strong><i class="fal fa-lock-alt"></i> Giriş başarısız, </strong>Kullanıcınıza firma atanmamış. Yöneticinize başvurun.</div>';
		}
		else {

			$processMessage = count($firmList) > 0 ? 'Lütfen firma seçin.' : 'yönlendiriliyorsunuz...';
			$result = 'ok';
			$message = '<div class="alert alert-success m-alert m-alert--air m-alert--outline animated fadeIn" role="alert"><strong><i class="fal fa-fingerprint"></i> Giriş başarılı, </strong> ' . $processMessage . '</div>';
			if (isset($_POST['keepmesignedin'])) {
				$setToCookie = md5($k_adi . $saltText . $k_pass . date('YMDHiS'));
				UpdateTable2('users', array('sessionId'), array($setToCookie), 'username', $k_adi);
				setcookie($siteCookiePrefix . 'sessionId' . $sitePhpSessionVersion, $setToCookie, time() + 3600 * 24 * 2000, $sitePath);
			}
		}
	}
	else if (UserLogin($k_adi, $k_pass) == 2) {
		$result = 'notactive';
		$message = '<div class="alert alert-warning m-alert m-alert--air m-alert--outline animated swing" role="alert"><strong><i class="fal fa-user-slash"></i> Kullanıcı pasif, </strong>sistem yöneticinizle iletişime geçin.</div>';
	}
	else {
		$result = 'fail';
		$message = '<div class="alert alert-warning m-alert m-alert--air m-alert--outline animated shake" role="alert"><strong><i class="fal fa-lock-alt"></i> Giriş başarısız, </strong>lütfen tekrar deneyin</div>';
	}
}

echo json_encode(array('result' => $result, 'message' => $message, 'firmList' => $firmList));
