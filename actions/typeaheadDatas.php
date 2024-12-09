
<?php
header('Content-Type: application/json; charset=UTF-8');

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

if ($action == 'odmOdemeTakipAliciList') {
    $search = (isset($_GET['search'])) ? $_GET['search'] : '';
    odmOdemeTakipAliciList($search);
}

function odmOdemeTakipAliciList($search)
{
    $param_odm_odemeyerleri = GetListDataFromTableWithSingleWhere('param_odm_odemeyerleri', 'unvan, id', 'unvan', 'active=1 AND unvan LIKE "%' . $search . '%"', false);
    echo json_encode($param_odm_odemeyerleri);
}