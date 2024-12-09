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


if ($action == 'YakitDepo') {
    YakitDepo(
        isset($_GET['tank_id']) ? MysqlSecureText($_GET['tank_id']) : 0
    );
}
function YakitDepo($tank_id)
{
    global $CurrentFirm;
    $giris = GetRowSumsWithSingleWhere('dep_yakit_giris', 'litre', 'sirket_id=' . $CurrentFirm['id'] . ' AND tank_id=' . $tank_id);
    $cikis = GetRowSumsWithSingleWhere('dep_yakit_cikis', 'litre', 'sirket_id=' . $CurrentFirm['id'] . ' AND tank_id=' . $tank_id);
    $kalan = $giris - $cikis;

    $dataTank = GetSingleDataFromTable('param_dep_tanklar', $tank_id);

//    $array = array('kapasite' => $CurrentFirm['tank_kapasite'], 'kalan' => $kalan);
    $array = array('tank_tag' => $dataTank['kisa_isim'], 'kapasite' => $dataTank['kapasite'], 'kalan' => $kalan);
    echo json_encode($array);
}




/* --------------------------------------- */
if ($action == 'YakitOrtalamaHighChart') {
    YakitOrtalamaHighChart();
}
function YakitOrtalamaHighChart()
{
    global $CurrentFirm;

    $start_date = date('Y-m-d', strtotime("1 months ago", strtotime(date('Y-m-d'))));
    $end_date   = date('Y-m-t', strtotime("this month", strtotime(date('Y-m-d'))));

    $data = GetManuelQuery('SELECT plaka, year(tarih) as yil, month(tarih) as ay, COALESCE(SUM(litre),0) as litretoplam, MIN(ilk_km) as ilkkm, MAX(son_km) as sonkm
FROM dep_yakit_cikis yakitcikis LEFT JOIN param_dep_araclar paramarac ON yakitcikis.arac_id = paramarac.id
WHERE yakitcikis.tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND yakitcikis.sirket_id=' . $CurrentFirm['id'] . ' AND paramarac.calctuketim=1 AND paramarac.calctuketimperiod=1 AND paramarac.active=1
GROUP BY year(tarih), month(tarih), arac_id ORDER BY plaka, yil, ay DESC', false); // Bos olan aylar olursa 0 donmedigi icin hata veriyor



    $arr = array_map(function($i) {
        settype($i['litretoplam'], "integer");
        settype($i['ilkkm'], "integer");
        settype($i['sonkm'], "integer");

        $calcAvg = 0;
        if ($i['sonkm'] != $i['ilkkm']) {
            $calcAvg = $i['sonkm'] - $i['ilkkm'];
            $calcAvg = $i['litretoplam'] / $calcAvg * 100;
        }

        return array('period' => $i['yil'] . '-' . $i['ay'], 'toplamlitre' =>  $i['litretoplam'], 'plaka' => $i['plaka'], 'ilkkm' => $i['ilkkm'], 'sonkm' => $i['sonkm'],
        'calcavg' => round(@$calcAvg,2)

        );
    }, $data);
    header('Content-Type: application/json');
    echo json_encode($arr);
    // echo json_encode($data);
}
/* --------------------------------------- */









if ($action == 'YakitTuketimTop') {
    YakitTuketimTop(
        isset($_GET['top']) ? MysqlSecureText($_GET['top']) : 10,
        isset($_GET['period']) ? MysqlSecureText($_GET['period']) : date('Y-m')
    );
}
function YakitTuketimTop($top=10, $period)
{
    global $CurrentFirm;

    $start_date = date('Y-m-d', strtotime("this month", strtotime(date($period))));
    $end_date   = date('Y-m-t', strtotime("this month", strtotime(date($period))));

    $data = GetManuelQuery('SELECT paramarac.plaka , SUM(yakitcikis.litre) AS tuketim FROM dep_yakit_cikis yakitcikis LEFT JOIN param_dep_araclar paramarac ON yakitcikis.arac_id = paramarac.id WHERE yakitcikis.sirket_id='. $CurrentFirm['id'] . ' AND tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '" GROUP BY arac_id ORDER BY tuketim DESC LIMIT ' . $top, false);

    $arr = array_map(function($i) {
        settype($i['tuketim'], "integer");
        return array($i['plaka'],$i['tuketim']);
    }, $data);

    echo json_encode($arr);
    // SIL TEST;
//    echo 'SELECT paramarac.plaka , SUM(yakitcikis.litre) AS tuketim FROM dep_yakit_cikis yakitcikis LEFT JOIN param_dep_araclar paramarac ON yakitcikis.arac_id = paramarac.id WHERE yakitcikis.sirket_id='. $CurrentFirm['id'] . ' AND tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '" GROUP BY arac_id ORDER BY tuketim DESC LIMIT ' . $top;
//    print_r($data);
}
/* --------------------------------------- */
if ($action == 'AracGirisCikisWidget') {
    AracGirisCikisWidget();
}
function AracGirisCikisWidget()
{
    global $CurrentFirm, $CurrentUser;

    $tableItemCount = 8;
    $page = 1;
    $start_date = date("Y-m-d 00:00:00");
    $end_date = date("Y-m-d 23:59:59");

    $dataWhereText  = 'agc.sirket_id=' . $CurrentFirm['id'];
    $dataWhereText .= ' AND agc.giris_tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
    $dataFromText   = 'gvn_aracgiriscikis agc ';
    $dataFromText  .= '';
    $dataSelectText  = 'agc.*';
    $dataSelectText .= ' ,CASE agc.arac_tur WHEN 1 THEN "Misafir" WHEN 2 THEN "Şirket" WHEN 3 THEN "Çöp" WHEN 4 THEN "Hammadde" END AS arac_tur_text';
    $dataSelectText .= ' ,CASE agc.cop_saha WHEN 1 THEN "Kaklık" WHEN 2 THEN "Kocabaş" WHEN 3 THEN "Diğer" END AS cop_saha_text';
    $dataOrderText  = 'id DESC';
    $dataList = GetListDataFromTableWithSingleWhereAndLimit($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, $page, $tableItemCount, false); ?>
    <div class="kt-widget6">
    <div class="kt-widget6__head">
        <div class="kt-widget6__item">
            <span>Giriş</span>
            <span>Çıkış</span>
            <span>Süre</span>
            <span>Tür</span>
            <span>Plaka</span>
            <span>Ad Soyad</span>
        </div>
    </div>
    <div class="kt-widget6__body">
        <? foreach ($dataList as $data) { ?>
            <div class="kt-widget6__item">
                <span><?=DateFormat($data['giris_tarih'], 'd/m/Y H:i')?></span>
                <span><?=DateFormat($data['cikis_tarih'], 'd/m/Y H:i')?></span>
                <span><?=CalculateTimeDifference($data['giris_tarih'], $data['cikis_tarih'])?></span>
                <span><?=$data['arac_tur_text']?></span>
                <span><?=$data['plaka']?></span>
                <span><?=$data['ad_soyad']?></span>
            </div>
        <? } ?>
    </div>
    </div><?
}