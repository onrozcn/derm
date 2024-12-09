<?php
/**
 * Created by PhpStorm.
 * User: Serhat Yılmaz
 * Date: 1.10.2016
 * Time: 02:15
 */

// $CurrentUser['permission']['izin_adi'];

$PermissionList = array(
    array(
        'cat_name' => 'Administration',
        'fields' => array(
            array('superadmin', 'Süper Admin', 'Süper Admin Yetkisi'),
            array('admin', 'Admin', 'Admin Yetkisi'),
        )
    ),
);

$PermissionListOfFirm = array(
    array(
        'cat_name' => 'Anasayfa Widget Yetkiler',
        'fields' => array(
            array('homeWidAracgiriscikis', 'Araç Giriş-Çıkış Widget Görüntüleme', 'Araç giriş-çıkış widget görüntüleyebilme'),
            array('homeWidDepo', 'Depo Widget Görüntüleme', 'Depo widget görüntüleyebilme'),
        )
    ),
    array(
        'cat_name' => 'Hammadde Modülü Yetkileri',
        'fields' => array(
            array('hamGirisPageView', 'Hammadde Giris Sayfası Görüntüleme', 'Hammadde giris sayfası görüntüleyebilme'),
        )
    ),
    array(
        'cat_name' => 'Ödemeler Modülü Yetkileri',
        'fields' => array(
            array('odmOdemeTakipPageView', 'Ödemeler Sayfası Görüntüleme', 'Ödemeler sayfası görüntüleyebilme'),
            array('odmOdemeTakipAction', 'Ödeme Ekleme Silme Düzenleme', 'Ödemeler sayfası ekeleme/silme/düzenleme'),
        )
    ),
    array(
        'cat_name' => 'Depo Modülü Yetkileri',
        'fields' => array(
            array('depYakitPageView', 'Yakıt Sayfası Görüntüleme', 'Yakıt sayfası görüntüleyebilme'),
            array('depYakitGirisTabView', 'Yakıt Giriş Tab Görüntüleme', 'Yakıt giriş sekmesi görüntüleyebilme'),
            array('depYakitCikisTabView', 'Yakıt Çıkış Tab Görüntüleme', 'Yakıt çıkış sekmesi görüntüleyebilme'),
            array('depYakitGirisAdd', 'Yakıt Giriş Kayıt Ekleme', 'Yakıt giriş kaydı ekleyebilme'),
            array('depYakitCikisAdd', 'Yakıt Çıkış Kayıt Ekleme', 'Yakıt çıkış kaydı ekleyebilme'),
            array('depYakitTeslimAlmaUser', 'Yakıt Teslim Alma', 'Yakıt teslim alma kullanıcısı'),
            array('depYakitTeslimEtmeUser', 'Yakıt Teslim Etme', 'Yakıt teslim etme kullanıcısı'),
            array('depRaporCikisPageView', 'Yakıt Çıkış Rapor Sayfası Görüntüleme', 'Yakıt çıkış rapor sayfası görüntüleyebilme'),
        )
    ),
    array(
        'cat_name' => 'Güvenlik Modülü Yetkileri',
        'fields' => array(
            array('gvnAracGiriscikisPage', 'Araç Giriş/Çıkış Sayfası Görüntüleme', 'Araç Giriş/Çıkıs sayfası görüntüleyebilme'),
            array('gvnAracGiriscikisAdd', 'Araç Giriş/Çıkış Ekleme', 'Araç Giriş/Çıkıs sayfası ekleyebilme'),
            array('gvnAracGiriscikisEdit', 'Araç Giriş/Çıkış Düzenleme', 'Araç Giriş/Çıkıs sayfası düzenleyebilme'),
            array('gvnAracGiriscikisRemove', 'Araç Giriş/Çıkış Silme', 'Araç Giriş/Çıkıs sayfası silebilme'),
            array('gvnAracGiriscikisExport', 'Data Dışarı aktarma modulu', 'xlsx / pdf / print'),
        )
    ),
    array(
        'cat_name' => 'Parametre Yetkileri Seçenekleri',
        'fields' => array(
            array('odmParameterManage', 'Ödeme Parametreleri Yönetebilme', 'Ödeme Parametreleri Yönetebilme'),
            array('hamParameterManage', 'Hammadde Parametreleri Yönetebilme', 'Hammadde Parametreleri Yönetebilme'),
            array('depParameterManage', 'Depo Parametreleri Yönetebilme', 'Hammadde Parametreleri Yönetebilme'),
        )
    ),
    array(
        'cat_name' => 'Bildirim Seçenekleri',
        'fields' => array(
            array('TELEGRAMgvnAracGiriscikis', 'Telegram Araç Giriş/Çıkış Bildirimi', 'Telegram bildirimi'),
            array('TELEGRAMdepYakit', 'Telegram Yakit Depo Giriş/Çıkış Bildirimi', 'Telegram bildirimi'),
        )
    ),
);

function GetUserPermissions($json)
{
    global $PermissionList;
    $json = HtmlDecode($json);
    $UserPermissions = array();
    foreach ($PermissionList as $perm) {
        foreach ($perm['fields'] as $pf) {
            $UserPermissions[$pf[0]] = 0;
        }

    }
    if (!empty($json)) {
        $DbPermissions = json_decode($json, true);

        foreach ($DbPermissions as $k => $v) {
            if (isset($UserPermissions[$k])) {
                $UserPermissions[$k] = $v;
            }
        }
    }

    return $UserPermissions;
}

function GetUserPermissionsOfFirm($user)
{
    global $PermissionListOfFirm, $firmParamTableName;

    $firmList = GetListDataFromTable($firmParamTableName, '*', 'id');
    $UserPermissions = array();

    foreach ($firmList as $firm) {
        foreach ($PermissionListOfFirm as $perm) {
            foreach ($perm['fields'] as $pf) {
                $UserPermissions[$firm['id']][$pf[0]] = 0;
            }
        }
    }

    foreach ($firmList as $firm) {
        $firmPermission = GetSingleDataFromTableWithSingleWhere('users_permissions', 'user_id=' . $user['id'] . ' and firm_id=' . $firm['id']);

        if (!isset($firmPermission) || empty($firmPermission)) {
            continue;
        }

        $DbPermissions = json_decode(HtmlDecode($firmPermission['permissions']), true);

        foreach ($DbPermissions as $k => $v) {
            if (isset($UserPermissions[$firm['id']][$k])) {
                $UserPermissions[$firm['id']][$k] = $v;
            }
        }
    }

    return $UserPermissions;
}

function SetUserPermissions($post)
{
    global $PermissionList;
    $UserPermissions = array();

    foreach ($PermissionList as $perm) {
        foreach ($perm['fields'] as $pf) {
            if (isset($post[$pf[0]]) && $post[$pf[0]] == 1) {
                $UserPermissions[$pf[0]] = (isset($post[$pf[0]])) ? $post[$pf[0]] : 0;
            }
        }
    }

    return UpdateTable2('users', array('permissions'), array(json_encode($UserPermissions)), 'id', $post['id']);
}

function SetUserPermissionsOfFirm($post)
{
    global $PermissionListOfFirm, $firmParamTableName;
    $firmList = GetListDataFromTable($firmParamTableName, '*', 'id');
    $savedFirmCount = 0;

    foreach ($firmList as $firm) {
        $userFirmPermissons = array();
        foreach ($PermissionListOfFirm as $perm) {
            foreach ($perm['fields'] as $pf) {
                if (isset($post[$pf[0] . '_' . $firm['id']]) && $post[$pf[0] . '_' . $firm['id']] == 1) {
                    $userFirmPermissons[$pf[0]] = 1;
                }
            }
        }

        $userFirmPermissonDb = GetSingleDataFromTableWithSingleWhere('users_permissions', 'user_id=' . $post['id'] . ' and firm_id=' . $firm['id']);

        if (count($userFirmPermissons) > 0) {
            if (isset($userFirmPermissonDb) && !empty($userFirmPermissonDb)) {
                if (UpdateTable2WithSingleWhere('users_permissions', array('permissions'), array(json_encode($userFirmPermissons)), 'id=' . $userFirmPermissonDb['id'])) {
                    $savedFirmCount++;
                }
            } else {
                if (AddToTable('users_permissions', array('user_id', 'firm_id', 'permissions'), array($post['id'], $firm['id'], json_encode($userFirmPermissons)), false)) {
                    $savedFirmCount++;
                }
            }
        } else {
            if (isset($userFirmPermissonDb) && !empty($userFirmPermissonDb)) {
                if (DeleteById('users_permissions', 'id', $userFirmPermissonDb['id'], false)) {
                    $savedFirmCount++;
                }
            } else {
                $savedFirmCount++;
            }
        }
    }

    return count($firmList) == $savedFirmCount;
}