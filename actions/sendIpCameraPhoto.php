<?php
require_once('../source/settings.php');
$CurrentFirm['id'] = 1;

//if (isset($_GET['action'])) {
//	$action = $_GET['action'];
//}
//else {
//	header('location:' . $siteUrl . 'index.php');
//	die();
////    echo $action;
//}
//
//if ($action == 'SendPhoto') {
//    SendPhoto();
//}


$users         = UserListByPermission('TELEGRAMipcamera', true);
//Myprint_r($users);
foreach ($users as $user) {
            TelegramSendMessage($setting['telegram_token'], '1640474785', 'sendMessage', 'ftp den gelen yok11');
//            echo 'if';
//echo $user['telegram_chatid'] . '<br>';
        }

//function SendPhoto()
//{
//    global  $setting;
//    $photoPath     = realpath(__DIR__ . '/../uploads/ipcamera/');
//    $scanPath      = array_diff(scandir($photoPath), array('..', '.', 'logs.txt')); // belirtilen karakterli dosyalari cikar
//    $receiverNames = implode(', ', array_column(UserListByPermission('TELEGRAMipcamera', true), 'username'));
//    $users         = UserListByPermission('TELEGRAMipcamera', true);
//
//    echo 'telegram_token: ' . $setting['telegram_token'] . '<br>';
////    print_r($receiverNames);
//
//    if (!$scanPath) {
//        foreach ($users as $user) {
//            TelegramSendMessage($setting['telegram_token'], '1640474785', 'sendMessage', 'ftp den gelen yok');
//            echo 'if';
//
//        }
//    } else {
//
//        foreach ($scanPath as $sp) {
//            if ( $setting['telegram_send_notification'] == true ) {
//                foreach ($users as $user) {
//                    TelegramSendMessage($setting['telegram_token'], $user['telegram_chatid'], 'sendPhoto', $sp, new CURLFile($photoPath . '\\' . $sp));
//                }
//            }
//            AddLogToTxt($photoPath . "/logs.txt", $sp . ' -> ' . date('Y-m-d H:i:s') . ' ' . $receiverNames, 200);
//            unlink($photoPath . '\\' . $sp);
//            echo 'else';
//        }
//
//    }
//
//}
//
//SendPhoto();



