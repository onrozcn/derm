<?php
$FirmPermissionList = GetListDataFromTable($firmParamTableName, '*', 'id');

function GetUserFirmPermissions($json)
{
	global $FirmPermissionList;

	$json = HtmlDecode($json);
	$UserFirmPermissions = array();

	foreach ($FirmPermissionList as $perm) {
		$UserFirmPermissions[$perm['id']] = 0;
	}

	if (!empty($json)) {
		$DbPermissions = json_decode($json, true);
		foreach ($DbPermissions as $k => $v) {
			if (isset($UserFirmPermissions[$k])) {
				$UserFirmPermissions[$k] = $v;
			}
		}
	}

	return $UserFirmPermissions;
}

function GetUserFirmList($json)
{
	global $FirmPermissionList;

	$UserFirmPermissions = GetUserFirmPermissions($json);
	$UserFirmList = array();

	foreach ($FirmPermissionList as $perm) {
		if (isset($UserFirmPermissions[$perm['id']]) && $UserFirmPermissions[$perm['id']] > 0) {
			$UserFirmList[] = $perm;
		}
	}

	return $UserFirmList;
}

function SetUserFirmPermissions($post)
{
    global $FirmPermissionList;

    $UserFirmPermissions = array();

    //foreach ($FirmPermissionList as $perm) {
    //    $UserFirmPermissions[$perm['id']] = 0;
    //}

    $selectedFirms = (isset($post['firmPermission']) && !empty($post['firmPermission'])) ? $post['firmPermission'] : array();
    foreach ($selectedFirms as $p) {
        $UserFirmPermissions[$p] = 1;
    }

    return json_encode($UserFirmPermissions);
}