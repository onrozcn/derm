<?php
require_once('../source/settings.php');
require_once('../source/backup.php');
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

if ($action == 'BackupAdd') {
    BackupAdd(
        isset($_POST['type']) ? MysqlSecureText($_POST['type']) : 1
    );
}

function BackupAdd($type) // 1 ftp + sql - 2 sql - 3 ftp
{
    global $sqlHost, $sqlUser, $sqlPass, $sqlName, $sqlPort;
    $filename = 'backup_' . date("Ymd_Hi");
    $backup = new Backup();

    if ($type == 1) {
        // ftp + sql yedeğini birlikte almak için
        $backup = new Backup([
            'db' => [
                'host' => $sqlHost,
                'user' => $sqlUser,
                'pass' => $sqlPass,
                'dbname' => $sqlName,
                'file' => __DIR__ . '/backup.sql'
            ],
            'folder' => [
                'dir' => '../../derm',
                'file' => '../backups/ftp+sql/full_' . $filename . '.zip',
                'exclude' => ['.idea', 'backups'] // bunlar hariç yedekle
            ]
        ]);
        $yedekle = $backup->full();
        if ($yedekle){
            JsonResult('ok','Full Başarıyla Yedeklendi.', 0);
        }
    } else if ($type == 2) {
        // sql yedeği almak için
        $mysqlBackup = $backup->mysql([
            'host' => $sqlHost,
            'user' => $sqlUser,
            'pass' => $sqlPass,
            'dbname' => $sqlName,
            'file' => '../backups/sql//sql_' . $filename . '.sql'
        ]);
        if ($mysqlBackup){
            JsonResult('ok','SQL Başarıyla Yedeklendi.', 0);
        }
    } else if ($type == 3) {
        // ftp yedeği almak için
        $folderBackup = $backup->folder([
            'dir' => '../../derm',
            'file' => '../backups/ftp/ftp_' . $filename . '.zip',
            'exclude' => ['.idea', 'backups'] // bunlar hariç yedekle
        ]);
        if ($folderBackup){
            JsonResult('ok','FTP Başarıyla Yedeklendi.', 0);
        }
    }
}





if ($action == 'BackupRemove') {
    BackupRemove(
        isset($_POST['type']) ? MysqlSecureText($_POST['type']) : '',
        isset($_POST['file']) ? MysqlSecureText($_POST['file']) : ''
    );
}

function BackupRemove($type, $file)
{
    global $siteUrl;

    if ( isset($type) && !empty($type) && isset($file) && !empty($file) ) {
        if ($type==1) {
            $path = 'backups/ftp+sql/';
        } else if ($type==2) {
            $path = 'backups/sql/';
        } else if ($type==3) {
            $path = 'backups/ftp/';
        }
        $fullPath = '../' . $path . '' . $file;
        if ( DeleteFile($fullPath) ) {
            JsonResult('ok','Yedek Silindi', 0);
        }
    }
}