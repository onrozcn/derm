<?php
require_once('../source/settings.php');


if (isset($_GET['action'])) {
	$action = $_GET['action'];
}
else {
	header('location:' . $siteUrl . 'index.php');
	die();
//    echo $action;
}

if ($action == 'SendPhoto') {
    SendPhoto();
}

function SendPhoto()
{
    global  $setting;
    $photoPath     = realpath(__DIR__ . '/../uploads/ipcamera/');
    $scanPath      = array_diff(scandir($photoPath), array('..', '.', 'logs.txt')); // belirtilen karakterli dosyalari cikar
    $receiverNames = implode(', ', array_column(UserListByPermission('TELEGRAMipcamera', true), 'username'));

    foreach ($scanPath as $sp) {
        if ( $setting['telegram_send_notification'] == true ) {
            $users = UserListByPermission('TELEGRAMipcamera', true);
            foreach ($users as $user) {
                TelegramSendMessage($setting['telegram_token'], $user['telegram_chatid'], 'sendPhoto', $sp, new CURLFile($photoPath . '\\' . $sp));
            }
        }
        AddLogToTxt($photoPath . "/logs.txt", $sp . ' -> ' . date('Y-m-d H:i:s') . ' ' . $receiverNames, 200);
        unlink($photoPath . '\\' . $sp);
    }
}



