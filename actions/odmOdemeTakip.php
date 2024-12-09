<?php
require_once('../source/settings.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

if ($action == 'odemeTakipTablo') {
    odemeTakipTablo(
		isset($_POST['type']) ? MysqlSecureText($_POST['type']) : 'screen',
		isset($_POST['page']) ? MysqlSecureText($_POST['page']) : 1,
		isset($_POST['orderBy']) ? $_POST['orderBy'] : 1,
		isset($_POST['ff_quickSearch']) ? $_POST['ff_quickSearch'] : '',
        isset($_POST['ff_kategoriId']) && !empty($_POST['ff_kategoriId']) ? $_POST['ff_kategoriId'] : 0,
		isset($_POST['ff_evrakno']) ? $_POST['ff_evrakno'] : '',
		isset($_POST['ff_borcluId']) && !empty($_POST['ff_borcluId']) ? $_POST['ff_borcluId'] : 0,
		isset($_POST['ff_odemeyeri']) && !empty($_POST['ff_odemeyeri']) ? $_POST['ff_odemeyeri'] : 0,
		isset($_POST['ff_cinsi']) ? $_POST['ff_cinsi'] : '',
        isset($_POST['ff_dovizId']) && !empty($_POST['ff_dovizId']) ? $_POST['ff_dovizId'] : 0,
        isset($_POST['ff_vadeDR']) && !empty($_POST['ff_vadeDR']) ? MysqlSecureText($_POST['ff_vadeDR']) : 'all',
        isset($_POST['ff_talep']) && !empty($_POST['ff_talep']) ? $_POST['ff_talep'] : 0,
        isset($_POST['ff_oncelik']) && !empty($_POST['ff_oncelik']) ? $_POST['ff_oncelik'] : 0,
        isset($_POST['ff_yontem']) && !empty($_POST['ff_yontem']) ? $_POST['ff_yontem'] : 0,
        isset($_POST['ff_odendigiDR']) && !empty($_POST['ff_odendigiDR']) ? MysqlSecureText($_POST['ff_odendigiDR']) : 'all',
        isset($_POST['ff_durum']) && !empty($_POST['ff_durum']) ? $_POST['ff_durum'] : 0
	);
}

function odemeTakipTablo($type, $page, $orderBy, $ff_quickSearch, $ff_kategoriId, $ff_evrakno, $ff_borcluId, $ff_odemeyeri, $ff_cinsi, $ff_dovizId, $ff_vadeDR, $ff_talep, $ff_oncelik, $ff_yontem, $ff_odendigiDR, $ff_durum)
{
   	global $CurrentFirm, $CurrentUser;
	$tableItemCount = 200;
	$showPage = 3;

    $dataWhereText  = 'oot.sirket_id=' . $CurrentFirm['id'];

    if (isset($ff_quickSearch) && !empty($ff_quickSearch)) {
        $dataWhereText  .= ' AND (poy.unvan LIKE "%' . $ff_quickSearch .'%" OR oot.cinsi LIKE "%' . $ff_quickSearch .'%" OR oot.id="' . $ff_quickSearch .'")';
    }
    if ($ff_kategoriId != 0) {
        if (is_array($ff_kategoriId)) {
            $dataWhereText  .= ' AND oot.kategori_id IN (' . implode(',', array_map('intval', $ff_kategoriId)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.kategori_id=' . $ff_kategoriId;
        }
    }
    if (isset($ff_evrakno) && !empty($ff_evrakno)) {
        $dataWhereText  .= ' AND oot.evrak_no="' . $ff_evrakno . '"';
    }
    if ($ff_borcluId != 0) {
        if (is_array($ff_borcluId)) {
            $dataWhereText  .= ' AND oot.borclusirket_id IN (' . implode(',', array_map('intval', $ff_borcluId)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.borclusirket_id=' . $ff_borcluId;
        }
    }
    if ($ff_odemeyeri != 0) {
        if (is_array($ff_odemeyeri)) {
            $dataWhereText  .= ' AND oot.odemeyeri_id IN (' . implode(',', array_map('intval', $ff_odemeyeri)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.odemeyeri_id=' . $ff_odemeyeri;
        }
    }
    if (isset($ff_cinsi) && !empty($ff_cinsi)) {
        $dataWhereText  .= ' AND oot.cinsi LIKE "%' . $ff_cinsi . '%"';
    }
    if ($ff_dovizId != 0) {
        if (is_array($ff_dovizId)) {
            $dataWhereText  .= ' AND oot.parabirimi_id IN (' . implode(',', array_map('intval', $ff_dovizId)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.parabirimi_id=' . $ff_dovizId;
        }
    }
    if ($ff_vadeDR != 'all') {
        $ff_vadeDRse = dateTimeRangeDateExplode($ff_vadeDR);
        if ($ff_vadeDR != 'all') $dataWhereText .= ' and oot.vade_tarih BETWEEN "' . $ff_vadeDRse[0] . '" AND "' . $ff_vadeDRse[1] . '"';
    }
    if ($ff_talep != 0) {
        if (is_array($ff_talep)) {
            $dataWhereText  .= ' AND oot.talep IN (' . implode(',', array_map('intval', $ff_talep)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.talep=' . $ff_talep;
        }
    }
    if ($ff_oncelik != 0) {
        if (is_array($ff_oncelik)) {
            $dataWhereText  .= ' AND oot.oncelik IN (' . implode(',', array_map('intval', $ff_oncelik)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.oncelik=' . $ff_oncelik;
        }
    }
    if ($ff_yontem != 0) {
        if (is_array($ff_yontem)) {
            $dataWhereText  .= ' AND oot.odeme_yontemi_id IN (' . implode(',', array_map('intval', $ff_yontem)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.odeme_yontemi_id=' . $ff_yontem;
        }
    }
    if ($ff_odendigiDR != 'all') {
        $ff_odendigiDRse = dateTimeRangeDateExplode($ff_odendigiDR);
        if ($ff_odendigiDR != 'all') $dataWhereText .= ' and oot.odendigi_tarih BETWEEN "' . $ff_odendigiDRse[0] . '" AND "' . $ff_odendigiDRse[1] . '"';
    }
    if ($ff_durum != 0) {
        if (is_array($ff_durum)) {
            $dataWhereText  .= ' AND oot.durum IN (' . implode(',', array_map('intval', $ff_durum)) . ')';
        } else {
            $dataWhereText  .= ' AND oot.durum=' . $ff_durum;
        }
    }



	// mode 1 . tümünü göster
	// mode 2 . ödenecek göster
	// mode 3 . ödenmiş göster
	// mode 4 . Kayit Sıralı Liste
    if ($orderBy==1) {
        $dataOrderText  = 'durum DESC, odendigi_tarih, vade_tarih, USDtutar DESC';
    }
    if ($orderBy==2) {
        $dataOrderText  = 'vade_tarih, borclusirket_id';
    }
    if ($orderBy==3) {
        $dataOrderText  = 'durum DESC, odendigi_tarih, vade_tarih, USDtutar DESC';
    }
    if ($orderBy==4) {
        $dataOrderText  = 'oot.id';
    }
    if ($orderBy==5) {
        $dataOrderText  = 'oot.oncelik, oot.vade_tarih';
    }


    $totalDataCount = GetRowCountWithSingleWhere('odm_odeme_takip oot LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)', $dataWhereText, false);
    $all = $page == 0;
    if ($page == 0 && $page != 'last') {
        $tableItemCount = $totalDataCount;
        $page = 1;
        $all = true;
    }else if ($page == 'last'){
        $page = ceil($totalDataCount / $tableItemCount);
        if ($page == 0) {
            $page = 1;
        }
        $all = false;
    }

    $dataFromText   = 'odm_odeme_takip oot ';
	$dataFromText  .= ' LEFT JOIN param_odm_kategoriler pok ON(oot.kategori_id=pok.id)';
	$dataFromText  .= ' LEFT JOIN param_odm_borclusirketler pob ON(oot.borclusirket_id=pob.id)';
	$dataFromText  .= ' LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)';
	$dataFromText  .= ' LEFT JOIN param_odm_odemeyontemleri poyn ON(oot.odeme_yontemi_id=poyn.id)';
	$dataFromText  .= ' LEFT JOIN param_ana_parabirimleri popb ON(oot.parabirimi_id=popb.id)';
	$dataFromText  .= ' LEFT JOIN temp tmp ON("1"=tmp.id)';
	$dataSelectText  = 'oot.*, pok.kategori as "kategori", pok.color as "kategorirenk", pob.tag as "borclusirket", pob.color as "borclusirketrenk", oot.odemeyeri_id as "odemeyeri_id", poy.unvan as "alacaklisirket", poy.vergino as "vergino", poyn.yontem as "odeme_yontemi", popb.kod as "para_birimi", parabirimi_id';
	$dataSelectText .= ', tmp.value1 as "tempanlikkur"';
    /*
    $dataSelectText .= ', CASE WHEN oot.durum="1" THEN oot.kur ELSE tmp.value1 END as "kur"';
    */

    $dataSelectText .= ', CASE WHEN oot.durum="1" THEN oot.kur 
    WHEN oot.durum="0" AND oot.parabirimi_id="1" THEN tmp.value1
    WHEN oot.durum="0" AND oot.parabirimi_id="2" THEN tmp.value1
    WHEN oot.durum="0" AND oot.parabirimi_id="3" THEN tmp.value2
    END as "kur"';

    /*
    $dataSelectText .= ', CASE 
    WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar 
    WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar 
    WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar*tmp.value1 
    WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar*oot.kur 
    ELSE "" END as "TRYtutar"';

    $dataSelectText .= ', CASE 
    WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar 
    WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar 
    WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar/tmp.value1 
    WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar/oot.kur 
    ELSE "" END as "USDtutar"';
    */

    $dataSelectText .= ', CASE 
    WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar 
    WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar 
    WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar*tmp.value1 
    WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar*oot.kur 
    WHEN oot.parabirimi_id="3" AND oot.durum="0" THEN oot.tutar*tmp.value2 
    WHEN oot.parabirimi_id="3" AND oot.durum="1" THEN oot.tutar*oot.kur 
    ELSE "" END as "TRYtutar"';

    $dataSelectText .= ', CASE 
    WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar/tmp.value1 
    WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar/oot.kur 
    WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar 
    WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar 
    WHEN oot.parabirimi_id="3" AND oot.durum="0" THEN oot.tutar*tmp.value2/tmp.value1 
    WHEN oot.parabirimi_id="3" AND oot.durum="1" THEN oot.tutar/oot.kur 
    ELSE "" END as "USDtutar"';




    $dataSelectText .= ', CASE WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN poy.try_iban WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.iban WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN poy.usd_iban WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.iban ELSE "" END as "iban"';

    $dataList = GetListDataFromTableWithSingleWhereAndLimit($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, $page, $tableItemCount, false);

    if ($type=='screen') { ?>
        <div class="row">
            <div class="col-xl-3 col-12 mb-4 d-flex justify-content-xl-start justify-content-center">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-sm btn-success"
                            onclick="odemeTakipTablo('xlsx',0,1,'<?=$ff_quickSearch?>',<?= json_encode($ff_kategoriId,JSON_NUMERIC_CHECK) ?>,'<?=$ff_evrakno?>',<?=json_encode($ff_borcluId,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_odemeyeri,JSON_NUMERIC_CHECK)?>,'<?=$ff_cinsi?>',<?=json_encode($ff_dovizId,JSON_NUMERIC_CHECK)?>,'<?=$ff_vadeDR?>',<?=json_encode($ff_talep,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_oncelik,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_yontem,JSON_NUMERIC_CHECK)?>,'<?=$ff_odendigiDR?>',<?=json_encode($ff_durum,JSON_NUMERIC_CHECK)?>);">
                        <i class="fas fa-file-excel"></i>Excel İndir</button>
                    <button type="button" class="btn btn-sm btn-danger"
                            onclick="odemeTakipTablo('pdf',0,1,'<?=$ff_quickSearch?>',<?= json_encode($ff_kategoriId,JSON_NUMERIC_CHECK) ?>,'<?=$ff_evrakno?>',<?=json_encode($ff_borcluId,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_odemeyeri,JSON_NUMERIC_CHECK)?>,'<?=$ff_cinsi?>',<?=json_encode($ff_dovizId,JSON_NUMERIC_CHECK)?>,'<?=$ff_vadeDR?>',<?=json_encode($ff_talep,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_oncelik,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_yontem,JSON_NUMERIC_CHECK)?>,'<?=$ff_odendigiDR?>',<?=json_encode($ff_durum,JSON_NUMERIC_CHECK)?>);">
                        <i class="fas fa-file-pdf"></i>PDF İndir</button>
                    <button type="button" class="btn btn-sm btn-secondary"
                            onclick="odemeTakipTablo('print',0,1,'<?=$ff_quickSearch?>',<?= json_encode($ff_kategoriId,JSON_NUMERIC_CHECK) ?>,'<?=$ff_evrakno?>',<?=json_encode($ff_borcluId,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_odemeyeri,JSON_NUMERIC_CHECK)?>,'<?=$ff_cinsi?>',<?=json_encode($ff_dovizId,JSON_NUMERIC_CHECK)?>,'<?=$ff_vadeDR?>',<?=json_encode($ff_talep,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_oncelik,JSON_NUMERIC_CHECK)?>,<?=json_encode($ff_yontem,JSON_NUMERIC_CHECK)?>,'<?=$ff_odendigiDR?>',<?=json_encode($ff_durum,JSON_NUMERIC_CHECK)?>);">
                        <i class="fas fa-print"></i>Yazdır</button>
                </div>
            </div>

            <div class="col-xl-6 mb-4 d-flex justify-content-center">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-sm btn-outline-primary <?=$ff_durum==array(0,1) && $orderBy==1?'active':''?>"  onclick="shortcutTum();scrollDownToBottom();">
                        Tümü<span class="d-none d-md-inline-block">nü Listele</span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary <?=$ff_durum==array(0) && $orderBy==2?'active':''?>"  onclick="shortcutOdenecek();scrollUpToTop();">
                        Ödenecekler<span class="d-none d-md-inline-block"> Listele</span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary <?=$ff_durum==array(1) && $orderBy==3?'active':''?>"  onclick="shortcutOdenmis();scrollDownToBottom();">
                        Ödenmişler<span class="d-none d-md-inline-block">i Listele</span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary <?=$ff_durum==array(0) && $orderBy==4?'active':''?>" onclick="shortcutKayitSirali();scrollDownToBottom();">
                        Kayıt Sıralı<span class="d-none d-md-inline-block">  Liste</span></button>
                </div>
            </div>


            <div class="col-xl-3 col-12 mb-4 d-flex justify-content-xl-end justify-content-center">
                <div id="actionButtons" class="text-right kt-hidden">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-info" onclick="odemeDuzenleHeader();"><i class="fal fa-pencil"></i> Düzenle</button>
                        <button type="button" class="btn btn-warning" onclick="odemeDuzenleKopyalaHeader();"><i class="fal fa-copy"></i> Kopyala</button>
                        <button type="button" class="btn btn-success" onclick="odemeOnayHeader();"><i class="fal fa-check"></i> Onayla</button>
                        <button type="button" class="btn btn-danger" onclick="odemeSilHeader();"><i class="fal fa-trash"></i> Sil</button>
                    </div>
                </div>
            </div>
        </div>
        <?
        if ($totalDataCount <= 0) { ?>
            <div class="alert alert-primary">
                <div class="alert-text"><i class="fal fa-info-circle"></i> <strong>Bulunamadı!</strong> Veritabanında aradığınız kriterlerde hiçbir kayıt bulunamadı.</div>
            </div>
        <?php } else { ?>
            <? paginationNew($type, $page, $orderBy, $totalDataCount, $tableItemCount, $showPage, 'odemeTakipTablo', $all, true); ?>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm derm-table" id="odemeTakipTable">
                            <thead class="thead-dark">
                            <tr>
                                <th colspan="12"></th>
                                <th colspan="3">Ödeme</th>
                                <th colspan="3"></th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Kategori</th>
                                <th>Evrak No</th>
                                <th>Borçlu</th>
                                <th>#</th>
                                <th>Ödeme Yeri</th>
                                <th>Cinsi</th>
                                <th>TL Tutar</th>
                                <th>USD Tutar</th>
                                <th>Dvz</th>
                                <th>Kur</th>
                                <th>Vade Tar.</th>
                                <th colspan="2">Plan</th>
                                <th>Yöntemi</th>
                                <th>Durum</th>
                                <th>Ödendi Tar.</th>
                                <th>Iban</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $tabloTRYtutar = 0;
                            $tabloUSDtutar = 0;
                            $counter = ($page * $tableItemCount) - $tableItemCount + 1;
                            foreach ($dataList as $data) {
                                $boldTRY = ($data['para_birimi'] == 'TL') ? 'kt-font-boldest' : '';
                                $boldUSD = ($data['para_birimi'] == 'USD') ? 'kt-font-boldest' : '';
                                $tabloTRYtutar += $data['TRYtutar'];
                                $tabloUSDtutar += $data['USDtutar'];
                                ?>
                            <tr style="color: <?=$data['kategorirenk']?>; background-color: <?=$data['duzenli_odeme'] == 1 ? '#d2e26c6e' : ''?>" data-rowid="<?= $data['id'] ?>">
                                <td><?= $data['id'] ?></td>
                                <td><?= $data['kategori'] ?></td>
                                <td><?= $data['evrak_no'] ?></td>
                                <td bgcolor="<?= $data['borclusirketrenk'] ?>" style="color: black;"><?= $data['borclusirket'] ?></td>
                                <td class="text-right" ondblclick="doubleClickEdit(<?= $data['id'] ?>)"><?= $data['odemeyeri_id'] ?></td>
                                <td><?= $data['alacaklisirket'] ?><i class="pl-3 kt-font-success fal fa-copy" data-clipboard="true" data-clipboard-text="<?= $data['alacaklisirket'] ?>"></i></td>
                                <td><?= $data['cinsi'] ?></td>
                                <td class="text-right <?= $boldTRY ?>"><?= FloatFormat($data['TRYtutar'], 2) ?></td>
                                <td class="text-right <?= $boldUSD ?>"><?= FloatFormat($data['USDtutar'], 2) ?></td>
                                <td><?= $data['para_birimi'] ?></td>
                                <td class="text-right"><?= FloatFormat($data['kur'], 4) ?></td>
                                <td><?= ($data['vade_tarih'] == '0000-00-00') ? '-' : JsSlashDateFixTr($data['vade_tarih']) ?></td>
                                <td style="color: black;"><div class="rate_talep" id="<?= $data['id'] ?>" data-score="<?= $data['talep'] ?>" <?= $data['durum'] == 1 ? 'data-readonly="true"' : '' ?>></div></td>
                                <td style="color: black;"><div class="rate_oncelik" id="<?= $data['id'] ?>"data-score="<?= $data['oncelik'] ?>" <?= $data['durum'] == 1 ? 'data-readonly="true"' : '' ?>></div></td>
                                <td><?= $data['odeme_yontemi'] ?></td>
                                <td style="color: black;"><div class="rate_durum" id="<?= $data['id'] ?>"data-score="<?= $data['durum'] ?>"></div></td>
                                <td><?= ($data['durum'] == 0) ? '-' : JsSlashDateFixTr($data['odendigi_tarih']) ?></td>
                                <td><span class="text-monospace"><?
                                        if ($data['durum'] == 1) {
                                            if (!empty($data['iban'])) {
                                                echo sameSizeCharacter(IbanBankNameCheck($data['iban']), 9) . ' ' . $data['iban'];
                                            }
                                        } else {
                                            $getLast = GetMaxIdDataOfWhere('odm_odeme_takip', 'odemeyeri_id="' . $data['odemeyeri_id'] . '" AND durum=1');
                                            // print_r($getLast);
                                            // echo '[[getlast: ' . substr($getLast['iban'], -7) . ' data: ' . substr($data['iban'], -7) . ']] -- ';
                                            if (empty($getLast['iban']) && empty($data['iban'])) {
                                                // echo '2 taraftada yok';
                                                echo '';
                                            } else if (empty($getLast['iban']) && isset($data['iban'])) {
                                                // echo 'son iban yok fakat param var. orn. ilk kayit';
                                                echo '<span class="kt-badge kt-badge--inline kt-badge--success animated infinite bounceIn p-1">' . sameSizeCharacter(IbanBankNameCheck($data['iban']), 9) . '</span> ' . $data['iban'];
                                            } else if (isset($getLast['iban']) && empty($data['iban'])) {
                                                // echo 'son iban var fakat param yok. orn. daha once odeme yapilmis, sonra paramdan iban silinmis';
                                                echo '<span class="kt-badge kt-badge--inline kt-badge--warning animated infinite bounceIn p-1">' . sameSizeCharacter(IbanBankNameCheck($data['iban']), 9) . '</span> ' . $data['iban'];
                                            } else if ((isset($getLast['iban']) && isset($data['iban'])) && $getLast['iban'] != $data['iban']) {
                                                // echo '2 taraftada da var fakat esit degil.';
                                                echo '<span class="kt-badge kt-badge--inline kt-badge--danger animated infinite bounceIn p-1">' . sameSizeCharacter(IbanBankNameCheck($data['iban']), 9) . '</span> ' . $data['iban'];
                                            } else if ($getLast['iban'] == $data['iban']) {
                                                // echo '2 taraftada da var ve esit ';
                                                echo sameSizeCharacter(IbanBankNameCheck($data['iban']), 9) . ' ' . $data['iban'];
                                            }
                                        }
                                        ?></span></td>
                                </tr><? $counter++;
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr class="table-active">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right kt-font-boldest"><i><?= FloatFormat($tabloTRYtutar, 2) ?></i></td>
                                <td class="text-right kt-font-boldest"><i><?= FloatFormat($tabloUSDtutar, 2) ?></i></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            paginationNew($type, $page, $orderBy, $totalDataCount, $tableItemCount, $showPage, 'odemeTakipTablo', $all, true); ?>

        <? }
    } else if ($type=='xlsx' || $type=='pdf' || $type=='print') {

        $setCreator = $CurrentUser['name'] . ' ' . $CurrentUser['surname'];
        $setCreatorInitial = $CurrentUser['initial'];
        $setLastModifiedBy = $CurrentUser['name'] . ' ' . $CurrentUser['surname'];
        $setTitle = 'dERM Report-Ödeme Takip';
        $setSubject = 'dERM Report-Ödeme Takip';
        $setDescription = 'dERM Report-Ödeme Takip';
        $setKeywords = 'dERM Report-Ödeme Takip';
        $setCategory = 'dERM Report-Ödeme Takip';
        $setSheetName = $setTitle;
        $setFileName = $setCreatorInitial . '-' . $setTitle;

        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator($setCreator)->setLastModifiedBy($setLastModifiedBy)->setTitle($setTitle)->setSubject($setSubject)->setDescription($setDescription)->setKeywords($setKeywords)->setCategory($setCategory);

        // Set Orientation and Paper Size
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE); // LANDSCAPE or PORTRAIT
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // Set page margins
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.5);

        // Set Fit to Page
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Set header and footer
        $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RYazdırma Tarihi: &D');
        $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&BOluşturan: ' . $spreadsheet->getProperties()->getCreator() . '&RSayfa: &P / &N');

        // Set first row print all page
        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        // Set Freeze
        $spreadsheet->getActiveSheet()->freezePane('A2');

        // Set first row filter
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:R1');


        // Add header
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Kategori')
            ->setCellValue('C1', 'Evrak No')
            ->setCellValue('D1', 'Borçlu')
            ->setCellValue('E1', 'Ödeme Yeri')
            ->setCellValue('F1', 'Cinsi')
            ->setCellValue('G1', 'TL Tutar')
            ->setCellValue('H1', 'USD Tutar')
            ->setCellValue('I1', 'Döviz')
            ->setCellValue('J1', 'Kur')
            ->setCellValue('K1', 'Vade Tar.')
            ->setCellValue('L1', 'Talep')
            ->setCellValue('M1', 'Öncelik')
            ->setCellValue('N1', 'Yöntemi')
            ->setCellValue('O1', 'Ödendiği Tar.')
            ->setCellValue('P1', 'Banka')
            ->setCellValue('Q1', 'Iban')
            ->setCellValue('R1', 'Vergi No');
        $rowActive = 2;

        // Add Data
        $dataoncelik = '';
        foreach ($dataList as $data) {
            if ($data['oncelik'] == 0) {
                $dataoncelik = '';
            } else if ($data['oncelik'] == 1) {
                $dataoncelik = '★';
            } else if ($data['oncelik'] == 2) {
                $dataoncelik = '★★';
            } else if ($data['oncelik'] == 3) {
                $dataoncelik = '★★★';
            } else if ($data['oncelik'] == 4) {
                $dataoncelik = '★★★★';
            }
            $spreadsheet->getActiveSheet()->setCellValue("A$rowActive", $data['id']);
            $spreadsheet->getActiveSheet()->setCellValue("B$rowActive", $data['kategori']);
            $spreadsheet->getActiveSheet()->setCellValue("C$rowActive", $data['evrak_no']);
            $spreadsheet->getActiveSheet()->setCellValue("D$rowActive", $data['borclusirket']);
            $spreadsheet->getActiveSheet()->setCellValue("E$rowActive", $data['alacaklisirket']);
            $spreadsheet->getActiveSheet()->setCellValue("F$rowActive", $data['cinsi']);
            $spreadsheet->getActiveSheet()->setCellValue("G$rowActive", $data['TRYtutar']);
            $spreadsheet->getActiveSheet()->setCellValue("H$rowActive", $data['USDtutar']);
            $spreadsheet->getActiveSheet()->setCellValue("I$rowActive", $data['para_birimi']);
            $spreadsheet->getActiveSheet()->setCellValue("J$rowActive", $data['kur']);
            $spreadsheet->getActiveSheet()->setCellValue("K$rowActive", \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( date($data['vade_tarih']) ));
            $spreadsheet->getActiveSheet()->setCellValue("L$rowActive", $data['talep'] == 1 ? '☎' : '');
            $spreadsheet->getActiveSheet()->setCellValue("M$rowActive", $dataoncelik);
            $spreadsheet->getActiveSheet()->setCellValue("N$rowActive", $data['odeme_yontemi']);
            $spreadsheet->getActiveSheet()->setCellValue("O$rowActive", $data['odendigi_tarih'] != '0000-00-00' ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( date($data['odendigi_tarih']) ) : '');
            $spreadsheet->getActiveSheet()->setCellValue("P$rowActive", IbanBankNameCheck($data['iban'])); //IbanBankNameCheck($data['iban'])
            $spreadsheet->getActiveSheet()->setCellValue("Q$rowActive", $data['iban']);
            $spreadsheet->getActiveSheet()->setCellValue("R$rowActive", $data['vergino']);

            $rowActive++;
        }

        // Insert Summmary
        //$objPHPExcel->getActiveSheet()->setCellValue("G$rowActive","=SUM(G2:G".($rowActive-1).")");
        $spreadsheet->getActiveSheet()->setCellValue("G$rowActive","=SUBTOTAL(9,G2:G".($rowActive-1).")");
        $spreadsheet->getActiveSheet()->setCellValue("H$rowActive","=SUBTOTAL(9,H2:H".($rowActive-1).")");

        // Calculate Rows
        $rowLast = $spreadsheet->getActiveSheet()->getHighestRow();

        // Set column widths
         foreach (range('B', 'R') as $columnID) {
             $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
         }

//        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(7);
//        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
//        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(13);
//        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
//        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(55);
//        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(28);
//        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16);
//        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(16);
//        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(9);
//        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11);
//        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(10);
//        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(19);
//        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(11);
//        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(30);

        // Set cell style
        $headerStyleArray = array(
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => ['argb' => 'b64526'],
                'endColor' => ['argb' => 'e66e2a']
            ),
            'font' => array(
                'bold' => true, 'color' => array('rgb' => 'FFFFFF')/*, 'size' => 11*//*, 'name' => 'Calibri' */
            ));
        $subtotalStyleArray = array(
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff00')
            ),
            'font' => array(
                'bold' => true, 'color' => array('rgb' => '000000')/*, 'size' => 12*//*, 'name' => 'Calibri' */)
        );
        $spreadsheet->getActiveSheet()->getStyle('A1:R1')->applyFromArray($headerStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('G'.$rowActive.':H'.$rowActive.'')->applyFromArray($subtotalStyleArray);

        //$spreadsheet->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setIndent(4);

        // Set column format
        $spreadsheet->getActiveSheet()->getStyle('G1:G' . $rowLast)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('H1:H' . $rowLast)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('K1:K' . $rowLast)->getNumberFormat()->setFormatCode('dd.mm.yyyy');
        $spreadsheet->getActiveSheet()->getStyle('O1:O' . $rowLast)->getNumberFormat()->setFormatCode('dd.mm.yyyy');





        if ($type=='xlsx') {
            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save("php://output");
            $responseFileData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'op' => 'ok',
                'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($responseFileData),
                'filename' => $setFileName . '.xlsx'
            );
            die(json_encode($response));
        }




        if ($type=='print') {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
            ob_start();
            $writer->save("php://output");
            $responseFileData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'op' => 'ok',
                'file' => "data:application/pdf;base64," . base64_encode($responseFileData),
                'filename' => $setFileName . '.pdf'
            );
            die(json_encode($response));
        }



        if ($type=='pdf') {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
            ob_start();
            $writer->save("php://output");
            $responseFileData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'op' => 'ok',
                'file' => "data:application/vnd.pdf;base64," . base64_encode($responseFileData),
                'filename' => $setFileName . '.pdf'
            );
            die(json_encode($response));
        }





/*
        if ($type=='pdf') {
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            //$mpdf->simpleTables = true;

            $table  = '<table>';
            $table .= '<thead><tr>';
            $table .= '<th>ID</th>';
            $table .= '<th>Kategori</th>';
            $table .= '<th>Evrak No</th>';
            $table .= '<th>Borçlu</th>';
            $table .= '<th>Ödeme Yeri</th>';
            $table .= '<th>Cinsi</th>';
            $table .= '<th>TL Tutar</th>';
            $table .= '<th>USD Tutar</th>';
            $table .= '<th>Döviz</th>';
            $table .= '<th>Vade Tar.</th>';
            $table .= '<th>Talep</th>';
            $table .= '<th>Öncelik</th>';
            $table .= '<th>Yöntemi</th>';
            $table .= '<th>Ödendiği Tar.</th>';
            $table .= '<th>Iban</th>';
            $table .= '</tr></thead>';
            $table .= '<tbody>';
            foreach ($dataList as $data) {
                $table .= '<tr>';
                $table .= '<td>' . $data['id'] . '</td>';
                $table .= '<td>' . $data['kategori'] . '</td>';
                $table .= '<td>' . $data['evrak_no'] . '</td>';
                $table .= '<td>' . $data['borclusirket'] . '</td>';
                $table .= '<td>' . $data['alacaklisirket'] . '</td>';
                $table .= '<td>' . $data['cinsi'] . '</td>';
                $table .= '<td>' . $data['TRYtutar'] . '</td>';
                $table .= '<td>' . $data['USDtutar'] . '</td>';
                $table .= '<td>' . $data['para_birimi'] . '</td>';
                $table .= '<td>' . $data['kur'] . '</td>';
                $table .= '<td>' . $data['vade_tarih'] . '</td>';
                $table .= '<td>' . $data['talep'] . '</td>';
                $table .= '<td>' . $data['oncelik'] . '</td>';
                $table .= '<td>' . $data['odeme_yontemi'] . '</td>';
                $table .= '<td>' . $data['odendigi_tarih'] . '</td>';
                $table .= '<td>' . $data['iban'] . '</td>';
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';



//            $table  = '<div>ID</div>';
//            $table .= '<div>Kategori</div>';
//            $table .= '<div>Evrak No</div>';
//            $table .= '<div>Borçlu</div>';
//            $table .= '<div>Ödeme Yeri</div>';
//            $table .= '<div>Cinsi</div>';
//            $table .= '<div>TL Tutar</div>';
//            $table .= '<div>USD Tutar</div>';
//            $table .= '<div>Döviz</div>';
//            $table .= '<div>Vade Tar.</div>';
//            $table .= '<div>Talep</div>';
//            $table .= '<div>Öncelik</div>';
//            $table .= '<div>Yöntemi</div>';
//            $table .= '<div>Ödendiği Tar.</div>';
//            $table .= '<div>Iban</div>';
//            $table .= '</br>';
//            foreach ($dataList as $data) {
//                $table .= '<div>' . $data['id'] . '</div>';
//                $table .= '<div>' . $data['kategori'] . '</div>';
//                $table .= '<div>' . $data['evrak_no'] . '</div>';
//                $table .= '<div>' . $data['borclusirket'] . '</div>';
//                $table .= '<div>' . $data['alacaklisirket'] . '</div>';
//                $table .= '<div>' . $data['cinsi'] . '</div>';
//                $table .= '<div>' . $data['TRYtutar'] . '</div>';
//                $table .= '<div>' . $data['USDtutar'] . '</div>';
//                $table .= '<div>' . $data['para_birimi'] . '</div>';
//                $table .= '<div>' . $data['kur'] . '</div>';
//                $table .= '<div>' . $data['vade_tarih'] . '</div>';
//                $table .= '<div>' . $data['talep'] . '</div>';
//                $table .= '<div>' . $data['oncelik'] . '</div>';
//                $table .= '<div>' . $data['odeme_yontemi'] . '</div>';
//                $table .= '<div>' . $data['odendigi_tarih'] . '</div>';
//                $table .= '<div>' . $data['iban'] . '</div>';
//                $table .= '</br>';
//            }


            $mpdf->WriteHTML($table);
            ob_start();
            $mpdf->Output();
            $responseFileData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'op' => 'ok',
                'file' => "data:application/pdf;base64," . base64_encode($responseFileData),
                'filename' => $setFileName . '.pdf'
            );
            die(json_encode($response));

        }

*/










    }
}


if ($action == 'anlikKurGuncelleOtoYKB') {
    anlikKurGuncelleOtoYKB();
}

function anlikKurGuncelleOtoYKB()
{
    $kur = DovizKuruYKB();
    $kurUSD = str_replace(',', '.', $kur['USD']);
    $kurEUR = str_replace(',', '.', $kur['EUR']);
    if ($kur) {
        if ( UpdateTable('temp', array('value1'), array($kurUSD),'id', 1) && UpdateTable('temp', array('value2'), array($kurEUR),'id', 1) ) {
            //JsonResult('ok','Kur ' . $kur . ' olarak güncellendi', 0,0, array('anlikKurValue'=>$kur));
            JsonResult('ok','Kur Dolar:' . $kurUSD . ' ve Euro: ' . $kurEUR . ' olarak güncellendi', 0,0, array('anlikKurValueUSD'=>$kurUSD,'anlikKurValueEUR'=>$kurEUR));
        }
    }
    else {
        JsonResult('fail', 'Kur güncelleme başarısız', 0);
    }
}

if ($action == 'anlikKurGuncelleManuel') {
    anlikKurGuncelleManuel(
        isset($_POST['anlikKurManualDegerUSD']) ? MysqlSecureText($_POST['anlikKurManualDegerUSD']) : 0,
        isset($_POST['anlikKurManualDegerEUR']) ? MysqlSecureText($_POST['anlikKurManualDegerEUR']) : 0
    );
}

function anlikKurGuncelleManuel($anlikKurDegerUSD, $anlikKurDegerEUR)
{
    $kurUSD = str_replace(',', '.', $anlikKurDegerUSD);
    $kurEUR = str_replace(',', '.', $anlikKurDegerEUR);

    if ( UpdateTable('temp', array('value1'), array($kurUSD),'id', 1) && UpdateTable('temp', array('value2'), array($kurEUR),'id', 1) ) {
        JsonResult('ok','Kur Dolar:' . $kurUSD . ' ve Euro: ' . $kurEUR . ' olarak güncellendi', 0,0, array('anlikKurValueUSD'=>$kurUSD,'anlikKurValueEUR'=>$kurEUR));
    }

    else {
        JsonResult('fail', 'Kur güncelleme başarısız', 0);
    }
}

if ($action == 'odemeKaydet') {
    odemeKaydet(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
        isset($_POST['odeme_kategori_id']) ? MysqlSecureText($_POST['odeme_kategori_id']) : 0,
        isset($_POST['odeme_evrak_no']) ? MysqlSecureText($_POST['odeme_evrak_no']) : '',
        isset($_POST['odeme_borclu_sirket_id']) ? MysqlSecureText($_POST['odeme_borclu_sirket_id']) : 0,
        isset($_POST['odeme_odemeyeri_typeahead']) ? MysqlSecureText($_POST['odeme_odemeyeri_typeahead']) : 0,
        isset($_POST['odeme_odemeyeri_id']) ? MysqlSecureText($_POST['odeme_odemeyeri_id']) : 0,
        isset($_POST['odeme_cinsi']) ? MysqlSecureText($_POST['odeme_cinsi']) : '',
        isset($_POST['odeme_tutar_formul']) ? MysqlSecureText($_POST['odeme_tutar_formul']) : 0,
        isset($_POST['odeme_parabirimi_id']) ? MysqlSecureText($_POST['odeme_parabirimi_id']) : 0,
        isset($_POST['odeme_vade_tarihi']) && isItDate($_POST['odeme_vade_tarihi']) ? JsSlashDateFix(MysqlSecureText($_POST['odeme_vade_tarihi'])) : '0000-00-00',
        isset($_POST['odeme_yontemi_id']) ? MysqlSecureText($_POST['odeme_yontemi_id']) : 0,
        isset($_POST['odeme_duzenli_odeme']) ? MysqlSecureText($_POST['odeme_duzenli_odeme']) : 0
    );
}

function odemeKaydet($id, $odeme_kategori_id, $odeme_evrak_no, $odeme_borclu_sirket_id, $odeme_odemeyeri_typeahead, $odeme_odemeyeri_id, $odeme_cinsi, $odeme_tutar_formul, $odeme_parabirimi_id, $odeme_vade_tarihi, $odeme_yontemi_id, $duzenli_odeme)
{
    global $CurrentUser, $CurrentFirm;

    if ($odeme_vade_tarihi == '0000-00-00' || empty($odeme_kategori_id) || empty($odeme_borclu_sirket_id) || empty($odeme_tutar_formul) || empty($odeme_parabirimi_id) || empty($odeme_yontemi_id)) {
        JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
    }
    else {
        $dataUserId = $CurrentUser['id'];
        $dataDatetime = date('Y-m-d H:i:s', time());

        if ($id > 0) {
            $tutar = eval('return ' . DotFix($odeme_tutar_formul).';');
            if (UpdateTable(
                'odm_odeme_takip',
                array('sirket_id', 'kategori_id', 'evrak_no', 'borclusirket_id', 'odemeyeri_id', 'cinsi', 'tutar_formul', 'tutar', 'parabirimi_id', 'vade_tarih', 'odeme_yontemi_id', 'duzenli_odeme', 'updateUserId', 'updateDatetime'),
                array($CurrentFirm['id'], $odeme_kategori_id, $odeme_evrak_no, $odeme_borclu_sirket_id, $odeme_odemeyeri_id, $odeme_cinsi, $odeme_tutar_formul, DotFix($tutar), $odeme_parabirimi_id, $odeme_vade_tarihi, $odeme_yontemi_id, $duzenli_odeme, $dataUserId, $dataDatetime),
                'id', $id)) {
                JsonResult('ok', 'Kayıt Düzenlendi' , $id);
            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
            }
        }
        else {
            $tutar = eval('return '.DotFix($odeme_tutar_formul).';');
            if (AddToTable(
                'odm_odeme_takip',
                array('sirket_id', 'kategori_id', 'evrak_no', 'borclusirket_id', 'odemeyeri_id', 'cinsi', 'tutar_formul', 'tutar', 'parabirimi_id', 'vade_tarih', 'odeme_yontemi_id', 'duzenli_odeme', 'recordUserId', 'recordDatetime'),
                array($CurrentFirm['id'], $odeme_kategori_id, $odeme_evrak_no, $odeme_borclu_sirket_id, $odeme_odemeyeri_id, $odeme_cinsi, $odeme_tutar_formul, DotFix($tutar), $odeme_parabirimi_id, $odeme_vade_tarihi, $odeme_yontemi_id, $duzenli_odeme, $dataUserId, $dataDatetime),
                false)) {
                JsonResult('ok', 'Kayıt eklendi', GetLastIdData('odm_odeme_takip'));

            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
            }
        }
    }
}


if ($action == 'odemeDuzenle') {
    odemeDuzenle(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function odemeDuzenle($id)
{
    global $CurrentFirm;

    $array = array('result' => 'fail', 'id' => $id, 'kategori_id' => '', 'evrak_no' => '', 'borclusirket_id' => '', 'odemeyeri_typeahead' => '', 'odemeyeri_id' => '', 'cinsi' => '', 'tutar_formul' => '', 'parabirimi_id' => '', 'kur' => '', 'vade_tarih' => '', 'durum_id' => '', 'odendigi_tarih' => '', 'odeme_yontemi_id' => '', 'duzenli_odeme' => '', 'oncelik' => '', 'durum' => '');

    if (empty($id)) {
        $array['result'] = 'empty';
    }
    else {
        $data = GetSingleDataFromTableWithSingleWhere('odm_odeme_takip', 'id=' . $id . ' AND sirket_id=' . $CurrentFirm['id']);
        $datatypeahead = GetSingleDataFromTableWithSingleWhere('param_odm_odemeyerleri', 'id=' . $data['odemeyeri_id'] . ' AND sirket_id=' . $CurrentFirm['id']);
        if (empty($data)) {
            $array['result'] = 'fail';
        }
        else {
            $array['result'] = 'ok';
            $array['kategori_id'] = $data['kategori_id'];
            $array['evrak_no'] = $data['evrak_no'];
            $array['borclusirket_id'] = $data['borclusirket_id'];
            $array['odemeyeri_typeahead'] = $datatypeahead['unvan'];
            $array['odemeyeri_id'] = $data['odemeyeri_id'];
            $array['cinsi'] = $data['cinsi'];
            $array['tutar_formul'] = $data['tutar_formul'];
            $array['parabirimi_id'] = $data['parabirimi_id'];
            $array['kur'] = $data['kur'];
            $array['vade_tarih'] = $data['vade_tarih'] == '0000-00-00' ? '' : JsSlashDateFixTr($data['vade_tarih']);
            $array['odendigi_tarih'] = $data['odendigi_tarih'] == '0000-00-00'? '' : JsSlashDateFixTr($data['odendigi_tarih']);
            $array['odeme_yontemi_id'] = $data['odeme_yontemi_id'];
            $array['odeme_yontemi_id'] = $data['odeme_yontemi_id'];
            $array['duzenli_odeme'] = $data['duzenli_odeme'];
            $array['oncelik'] = $data['oncelik'];
            $array['durum'] = $data['durum'];
        }
    }

    echo json_encode($array);
}



if ($action == 'odemeOnayKaydet') {
    odemeOnayKaydet(
        isset($_POST['odeme_onay_id']) ? MysqlSecureText($_POST['odeme_onay_id']) : 0,
        isset($_POST['odeme_onay_kur']) ? MysqlSecureText($_POST['odeme_onay_kur']) : 0,
        isset($_POST['odeme_onay_odendigi_tarih']) && isItDate($_POST['odeme_onay_odendigi_tarih']) ? JsSlashDateFix(MysqlSecureText($_POST['odeme_onay_odendigi_tarih'])) : '0000-00-00',
        isset($_POST['odeme_onay_yontemi_id']) ? MysqlSecureText($_POST['odeme_onay_yontemi_id']) : 0,
        isset($_POST['odeme_onay_iban']) ? MysqlSecureText($_POST['odeme_onay_iban']) : ''
    );
}

function odemeOnayKaydet($id, $odeme_kur, $odeme_onay_yontemi_id, $odeme_onay_odendigi_tarih, $odeme_onay_iban)
{
    global $CurrentUser, $CurrentFirm;

    if (empty($id) || empty($odeme_kur) || $odeme_onay_yontemi_id == '0000-00-00' || empty($odeme_onay_odendigi_tarih) ) {
        JsonResult('empty', 'Lütfen zorunla alanları doldurun' . '<br>-$id: ' . $id . '<br>-$odeme_kur: ' . $odeme_kur . '<br>-$odeme_onay_yontemi_id: ' . $odeme_onay_yontemi_id . '<br>-$odeme_onay_odendigi_tarih: ' . $odeme_onay_odendigi_tarih     , $id);
    }
    else {
        $dataUserId = $CurrentUser['id'];
        $dataDatetime = date('Y-m-d H:i:s', time());


        if (UpdateTable(
            'odm_odeme_takip',
            array('durum', 'talep', 'oncelik', 'kur', 'odendigi_tarih', 'odeme_yontemi_id', 'iban', 'updateUserId', 'updateDatetime'),
            array(1, 0, 0, DotFix($odeme_kur), $odeme_onay_yontemi_id, $odeme_onay_odendigi_tarih, $odeme_onay_iban, $dataUserId, $dataDatetime),
            'id', $id)) {
            JsonResult('ok', 'Ödendi Olarak Düzenlendi' , $id);
        }
        else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
        }


    }
}


if ($action == 'odemeOnayIptal') {
    odemeOnayIptal(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function odemeOnayIptal($id)
{
    global $CurrentUser;

    if (empty($id)) {
        JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
    }
    else {
        $dataUserId = $CurrentUser['id'];
        $dataDatetime = date('Y-m-d H:i:s', time());

        if (UpdateTable(
            'odm_odeme_takip',
            array('durum', 'kur', 'odendigi_tarih', 'iban', 'updateUserId', 'updateDatetime'),
            array(0, 0, '0000-00-00', '', $dataUserId, $dataDatetime),
            'id', $id)) {
            JsonResult('ok', 'Onay İptal Edildi' , $id);
        }
        else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
        }
    }
}


if ($action == 'odemeOnayGetir') {
    odemeOnayGetir(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function odemeOnayGetir($id)
{
    global $CurrentFirm, $DovizKuruUSD, $DovizKuruEUR;

    $array = array('result' => 'fail', 'odeme_onay_id' => $id, 'kur' => '','borclutag' => '', 'durum' => '', 'odendigi_tarih' => '', 'alacaklifirma' => '', 'tutar' => '', 'parabirimi' => '', 'odeme_yontemi_id' => '', 'odeme_onay_iban' => '');

    if (empty($id)) {
        $array['result'] = 'empty';
    }
    else {

        $dataFromText   = 'odm_odeme_takip oot ';
        $dataFromText  .= ' left join param_odm_borclusirketler pob on(oot.borclusirket_id=pob.id)';
        $dataFromText  .= ' left join param_odm_odemeyerleri poy on(oot.odemeyeri_id=poy.id)';
        $dataFromText  .= ' left join param_ana_parabirimleri pap on(oot.parabirimi_id=pap.id)';
        $dataSelectText = 'oot.id as "odeme_onay_id", pob.tag as "borclutag", poy.unvan as "alacakliunvan", oot.kur as "kur", oot.tutar as "tutar", pap.kod as "parabirimi", oot.durum, oot.odendigi_tarih as "odendigi_tarih", oot.odeme_yontemi_id as "odeme_yontemi_id", oot.parabirimi_id';
        $dataSelectText .= ', CASE WHEN oot.parabirimi_id = "1" THEN poy.try_iban ELSE poy.usd_iban END as "banka_iban"';

        $data = GetSingleRowDataFromTableWithSingleWhere($dataFromText, $dataSelectText,'oot.id=' . $id . ' AND oot.sirket_id=' . $CurrentFirm['id'], false);

        if (empty($data)) {
            $array['result'] = 'fail';
        }
        else {
            $array['result'] = 'ok';
            $array['odeme_onay_id'] = $data['odeme_onay_id'];
            $array['borclutag'] = $data['borclutag'];
            $array['alacaklifirma'] = $data['alacakliunvan'];
            $array['tutar'] = FloatFormat($data['tutar'], 2);
            $array['parabirimi'] = $data['parabirimi'];
            $array['durum'] = $data['durum'];
            $array['odeme_onay_banka'] = IbanBankNameCheck($data['banka_iban']);
            $array['odeme_onay_iban'] = $data['banka_iban'];
            $array['odeme_yontemi_id'] = $data['odeme_yontemi_id'];
            if ($data['durum'] == 0){
                if ($data['parabirimi_id']==1) {
                    $array['kur'] = $DovizKuruUSD;
                } else if ($data['parabirimi_id']==2) {
                    $array['kur'] = $DovizKuruUSD;
                } else if ($data['parabirimi_id']==3) {
                    $array['kur'] = $DovizKuruEUR;
                }
                $array['odendigi_tarih'] = date('d/m/Y');
            } else {
                $array['kur'] = $data['kur'];
                $array['odendigi_tarih'] = JsSlashDateFixTr($data['odendigi_tarih']);
            }
        }
    }

    echo json_encode($array);
}


if ($action == 'odemeSilGetData') {
    odemeSilGetData(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function odemeSilGetData($id)
{
    global $CurrentFirm;

    $array = array('result' => 'fail', 'borclu' => '', 'borclurenk' => '', 'alacakli' => '', 'tutar' => '', 'parabirimi' => '', 'durum' => '');

    if (empty($id)) {
        $array['result'] = 'empty';
    }
    else {
        $dataFromText   = 'odm_odeme_takip oot ';
        $dataFromText  .= ' LEFT JOIN param_odm_borclusirketler pob ON(oot.borclusirket_id=pob.id)';
        $dataFromText  .= ' LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)';
        $dataFromText  .= ' LEFT JOIN param_ana_parabirimleri popb ON(oot.parabirimi_id=popb.id)';
        $dataSelectText  = 'oot.*, pob.tag as "borclu", pob.color as "borclurenk", poy.unvan as "alacakli", oot.tutar as "tutar", popb.kod as "parabirimi", oot.durum as "durum"';
        $dataWhereText = 'oot.id=' . $id . ' AND oot.sirket_id=' . $CurrentFirm['id'];
        $data = GetSingleRowDataFromTableWithSingleWhere($dataFromText, $dataSelectText, $dataWhereText, false);
        if (empty($data)) {
            $array['result'] = 'fail';
        }
        else {
            $array['result'] = 'ok';
            $array['borclu'] = $data['borclu'];
            $array['borclurenk'] = Hex2Rgba($data['borclurenk'], 0.6);
            $array['alacakli'] = $data['alacakli'];
            $array['tutar'] = FloatFormat($data['tutar'], 2);
            $array['parabirimi'] = $data['parabirimi'];
            $array['durum'] = $data['durum'];
        }
    }

    echo json_encode($array);
}


if ($action == 'odemeSil') {
    odemeSil(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function odemeSil($id)
{
    if (empty($id)) {
        JsonResult('empty', 'Kayit secilmemis', 0);
    }
    else {
        if (DeleteById('odm_odeme_takip', 'id', $id, false)) {
            JsonResult('ok', 'Silindi', 0);
        }
        else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
        }
    }
}


if ($action == 'odemeTalep') {
    odemeTalep(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
        isset($_POST['value']) ? MysqlSecureText($_POST['value']) : 0
    );
}

function odemeTalep($id, $value)
{
    if (empty($id)) {
        JsonResult('empty', 'Kayit secilmemis', 0);
    }
    else {
        if (UpdateTable(
            'odm_odeme_takip',
            array('talep'),
            array($value),
            'id', $id)) {
            JsonResult('ok', 'Talep Düzenlendi' , $id);
        }
        else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
        }
    }
}


if ($action == 'odemeOncelik') {
    odemeOncelik(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
        isset($_POST['value']) ? MysqlSecureText($_POST['value']) : 0
    );
}

function odemeOncelik($id, $value)
{
    if (empty($id)) {
        JsonResult('empty', 'Kayit secilmemis', 0);
    }
    else {
        if (UpdateTable(
            'odm_odeme_takip',
            array('oncelik'),
            array($value),
            'id', $id)) {
            JsonResult('ok', 'Öncelik Düzenlendi' , $id);
        }
        else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
        }
    }
}


if ($action == 'odemeDurum') {
    odemeDurum(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
        isset($_POST['value']) ? MysqlSecureText($_POST['value']) : 0
    );
}

function odemeDurum($id, $value)
{
    global $CurrentFirm, $DovizKuruUSD, $DovizKuruEUR;

    $dataFromText = 'odm_odeme_takip oot ';
    $dataFromText .= ' left join param_odm_borclusirketler pob on(oot.borclusirket_id=pob.id)';
    $dataFromText .= ' left join param_odm_odemeyerleri poy on(oot.odemeyeri_id=poy.id)';
    $dataFromText .= ' left join param_ana_parabirimleri pap on(oot.parabirimi_id=pap.id)';
    $dataSelectText = 'oot.id as "odeme_onay_id", pob.tag as "borclutag", poy.unvan as "alacakliunvan", oot.kur as "kur", oot.tutar as "tutar", pap.kod as "parabirimi", oot.durum, oot.odendigi_tarih as "odendigi_tarih", oot.odeme_yontemi_id as "odeme_yontemi_id", parabirimi_id';
    $dataSelectText .= ', CASE WHEN oot.parabirimi_id = "1" THEN poy.try_iban ELSE poy.usd_iban END as "banka_iban"';

    $data = GetSingleRowDataFromTableWithSingleWhere($dataFromText, $dataSelectText, 'oot.id=' . $id . ' AND oot.sirket_id=' . $CurrentFirm['id'], false);

    if ($data['parabirimi_id'] == 1) {
        $DovizKuru = $DovizKuruUSD;
    } else if ($data['parabirimi_id'] == 2) {
        $DovizKuru = $DovizKuruUSD;
    } else if ($data['parabirimi_id'] == 3) {
        $DovizKuru = $DovizKuruEUR;
    }

    if (empty($id)) {
        JsonResult('empty', 'Kayit secilmemis', 0);
    }
    else {
        if ($value==1) {
            if (UpdateTable(
                'odm_odeme_takip',
                array('durum', 'talep', 'oncelik', 'kur', 'iban', 'odendigi_tarih'),
                array($value, 0, 0, $DovizKuru, $data['banka_iban'], date('Y-m-d')),
                'id', $id)) {
                JsonResult('ok', 'Durum Düzenlendi' , $id);
            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
            }
        } else if ($value==0) {
            if (UpdateTable(
                'odm_odeme_takip',
                array('durum', 'kur', 'iban', 'odendigi_tarih'),
                array($value, 0, '', '0000-00-00'),
                'id', $id)) {
                JsonResult('ok', 'Durum Düzenlendi' , $id);
            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
            }
        } else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
        }





    }
}


if ($action == 'firmaDefaults') {
    firmaDefaults(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function firmaDefaults($id)
{
    $array = array('soncins_result' => 'fail', 'soncins_value' => '','duzenliodeme_result' => 'fail', 'duzenliodeme_value' => '');

    if (empty($id)) {
        $array['result'] = 'newcompany';
    }
    else {
        $sonCins = GetMaxIdDataOfFieldWithId('odm_odeme_takip', 'odemeyeri_id', $id);
        if (isset($sonCins['id']) && !empty($sonCins['id'])) {
            $array['soncins_result'] = 'ok';
            $array['soncins_value'] = $sonCins['cinsi'];
        }
        else if (empty($sonCins['cinsi'])) {
            $array['soncins_result'] = 'empty';
            $array['soncins_value'] = '';
        }
        // duzenli odeme tespit
        $defaultDuzenliOdeme = GetSingleDataFromTableWithSingleWhere('param_odm_odemeyerleri', 'id=' . $id);
        $array['duzenliodeme_result'] = 'ok';
        $array['duzenliodeme_value'] = $defaultDuzenliOdeme['default_duzenli_odeme'];
    }
    echo json_encode($array);
}


if ($action == 'firmaLastTransaction') {
    firmaLastTransaction(
        isset($_POST['odemeyeriid']) ? MysqlSecureText($_POST['odemeyeriid']) : 0,
        isset($_POST['borcluid']) ? MysqlSecureText($_POST['borcluid']) : 0,
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function firmaLastTransaction($odemeyeriid, $borcluid, $id)
{
    if (empty($odemeyeriid)) { ?>
        <div class="alert alert-primary">
            <div class="alert-text"><i class="fal fa-info-circle"></i> <strong>Bulunamadı!</strong> Veritabanında aradığınız kriterlerde hiçbir kayıt bulunamadı.</div>
        </div>
    <? } else {
        $borcluFirmList = GetListDataFromTable('param_odm_borclusirketler', 'id, tag, unvan', 'id=' . $borcluid . ' DESC');
        // $dataWhereText = 'param_odm_borclusirketler pob ';
        // $dataFromText  = ' RIGHT JOIN odm_odeme_takip oot ON(pob.id=oot.borclusirket_id)';
        // $borcluFirmList = GetListDataFromTable($dataFromText, 'pob.*', 'pob.id=' . $borcluid . ' DESC', true);
        ?>
        <table class="table table-bordered table-sm derm-table mb-0">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>İşlem</th>
                <th>Borçlu</th>
                <th>Evrak No</th>
                <th>Cinsi</th>
                <th>TL Tutar</th>
                <th>USD Tutar</th>
                <th></th>
                <th>Vade</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($borcluFirmList as $borcluFirm) {
                $dataWhereText  = 'borclusirket_id=' . $borcluFirm['id'] . ' AND odemeyeri_id=' . $odemeyeriid . ' AND durum=0';
                $dataFromText   = 'odm_odeme_takip oot ';
                $dataFromText  .= ' LEFT JOIN param_odm_borclusirketler pob ON(oot.borclusirket_id=pob.id)';
                $dataFromText  .= ' LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)';
                $dataFromText  .= ' LEFT JOIN param_ana_parabirimleri popb ON(oot.parabirimi_id=popb.id)';
                $dataFromText  .= ' LEFT JOIN temp tmp ON("1"=tmp.id)';
                $dataSelectText  = 'oot.*, pob.tag as "borclutag", pob.color AS "borclucolor", popb.kod AS "parabirimi"';
                $dataSelectText .= ', CASE WHEN oot.durum="1" THEN oot.kur ELSE tmp.value1 END as "kur"';
                $dataSelectText .= ', CASE WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar*tmp.value1 WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar*oot.kur ELSE "" END as "TRYtutar"';
                $dataSelectText .= ', CASE WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar/tmp.value1 WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar/oot.kur ELSE "" END as "USDtutar"';
                $dataOrderText   = 'oot.borclusirket_id=' . $borcluid . ' DESC, oot.vade_tarih';
                $data = GetListDataFromTableWithSingleWhere($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, false);
                if (count($data) != 0) {
                    $sirketToplamTRYtutar = ''; $sirketToplamUSDtutar = '';
                    foreach ($data as $d) {
                        $boldTRY = ($d['parabirimi'] == 'TL') ? 'kt-font-boldest' : '';
                        $boldUSD = ($d['parabirimi'] == 'USD') ? 'kt-font-boldest' : '';
                        $sirketToplamTRYtutar += $d['TRYtutar']; $sirketToplamUSDtutar += $d['USDtutar']; ?>
                        <tr class="<?=$d['id']==$id?'table-warning':''?>" <? echo $id?>>
                            <td class="text-center"><?=$d['id']?></td>
                            <td class="text-center"><? if ($borcluid == $d['borclusirket_id']) { ?><button type="button" class="btn btn-outline-info btn-icon btn-xs" onclick="$('#odemeKaydetModal').modal('hide'); setTimeout(function(){ odemeDuzenle(<?=$d['id']?>); }, 500);"><i class="fal fa-pencil"></i></button><? } ?></td>
                            <td bgcolor="<?=$d['borclucolor']?>"><?=$d['borclutag']?></td>
                            <td><?=$d['evrak_no']?></td>
                            <td><?=$d['cinsi']?></td>
                            <td class="text-right <?=$boldTRY?>"><?= FloatFormat($d['TRYtutar'], 2)?></td>
                            <td class="text-right <?=$boldUSD?>"><?= FloatFormat($d['USDtutar'], 2)?></td>
                            <td><?=$d['parabirimi']?></td>
                            <td class="kt-font-boldest"><?=JsSlashDateFixTr($d['vade_tarih']) ?></td>
                        </tr>
                    <? } ?>
                        <tr>
                            <td class="kt-font-boldest kt-font-danger text-center" colspan="5"><?=$borcluFirm['unvan']?></td>
                            <td class="kt-font-boldest kt-font-danger text-right"><?=FloatFormat($sirketToplamTRYtutar, 2)?></td>
                            <td class="kt-font-boldest kt-font-danger text-right"><?=FloatFormat($sirketToplamUSDtutar, 2)?></td>
                            <td></td>
                            <td></td>
                        </tr>
                <? } ?>
            <? }
            /*--- GENEL TOPLAM HESAPLAMA ---*/
            $genelToplamTRYtutar = ''; $genelToplamUSDtutar = ''; ?>
            <? foreach ($borcluFirmList as $borcluFirm) {
                $dataWhereText  = 'borclusirket_id=' . $borcluFirm['id'] . ' AND odemeyeri_id=' . $odemeyeriid . ' AND durum=0';
                $dataFromText   = 'odm_odeme_takip oot ';
                $dataFromText  .= ' LEFT JOIN param_odm_borclusirketler pob ON(oot.borclusirket_id=pob.id)';
                $dataFromText  .= ' LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)';
                $dataFromText  .= ' LEFT JOIN param_ana_parabirimleri popb ON(oot.parabirimi_id=popb.id)';
                $dataFromText  .= ' LEFT JOIN temp tmp ON("1"=tmp.id)';
                $dataSelectText  = 'oot.*, pob.tag as "borclutag", pob.color AS "borclucolor", popb.kod AS "parabirimi"';
                $dataSelectText .= ', CASE WHEN oot.durum="1" THEN oot.kur ELSE tmp.value1 END as "kur"';
                $dataSelectText .= ', CASE WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar*tmp.value1 WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar*oot.kur ELSE "" END as "TRYtutar"';
                $dataSelectText .= ', CASE WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar/tmp.value1 WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar/oot.kur ELSE "" END as "USDtutar"';
                $dataOrderText   = 'oot.borclusirket_id=' . $borcluid . ' DESC, oot.vade_tarih';
                $data = GetListDataFromTableWithSingleWhere($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, false);
                foreach ($data as $d) {
                    $genelToplamTRYtutar += $d['TRYtutar']; $genelToplamUSDtutar += $d['USDtutar'];
                }
            } ?>
            <tr class="table-active">
                <td class="kt-font-boldest text-center" colspan="5">Genel Toplam</td>
                <td class="kt-font-boldest text-right"><?=FloatFormat($genelToplamTRYtutar, 2)?></td>
                <td class="kt-font-boldest text-right"><?=FloatFormat($genelToplamUSDtutar, 2)?></td>
                <td></td>
                <td></td>
            </tr>
            <!-- GENEL TOPLAM HESAPLAMA -->
            </tbody>
        </table>
    <? }
}


if ($action == 'odemePlan') {
    odemePlan();
}

function odemePlan()
{
    global $CurrentFirm;

    $dataWhereText  = 'oot.sirket_id=' . $CurrentFirm['id'] .  ' AND oot.durum=0';
    $dataFromText   = 'odm_odeme_takip oot ';
    $dataFromText  .= ' LEFT JOIN param_odm_borclusirketler pob ON(oot.borclusirket_id=pob.id)';
    $dataFromText  .= ' LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)';
    $dataFromText  .= ' LEFT JOIN param_ana_parabirimleri popb ON(oot.parabirimi_id=popb.id)';
    $dataFromText  .= ' LEFT JOIN temp tmp ON("1"=tmp.id)';
    $dataSelectText  = 'oot.*, pob.tag as "borclutag", pob.color AS "borclucolor", popb.kod AS "parabirimi"';
    $dataSelectText .= ', CASE WHEN oot.durum="1" THEN oot.kur ELSE tmp.value1 END as "kur"';
    $dataSelectText .= ', CASE WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar*tmp.value1 WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar*oot.kur ELSE "" END as "TRYtutar"';
    $dataSelectText .= ', CASE WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar/tmp.value1 WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar/oot.kur ELSE "" END as "USDtutar"';
    $dataOrderText   = 'oot.id';
    $data = GetListDataFromTableWithSingleWhere($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, false);



    $oncelikTRY_zero = 0;
    $oncelikTRY_one = 0;
    $oncelikTRY_two = 0;
    $oncelikTRY_three = 0;
    $oncelikTRY_four= 0;

    $oncelikUSD_zero = 0;
    $oncelikUSD_one = 0;
    $oncelikUSD_two = 0;
    $oncelikUSD_three = 0;
    $oncelikUSD_four = 0;

    foreach ($data as $d) {
        if ($d['oncelik'] == 0) {
            $oncelikTRY_zero += $d['TRYtutar'];
            $oncelikUSD_zero += $d['USDtutar'];
        }
        if ($d['oncelik'] == 1) {
            $oncelikTRY_one += $d['TRYtutar'];
            $oncelikUSD_one += $d['USDtutar'];
        }
        if ($d['oncelik'] == 2) {
            $oncelikTRY_two += $d['TRYtutar'];
            $oncelikUSD_two += $d['USDtutar'];
        }
        if ($d['oncelik'] == 3) {
            $oncelikTRY_three += $d['TRYtutar'];
            $oncelikUSD_three += $d['USDtutar'];
        }
        if ($d['oncelik'] == 4) {
            $oncelikTRY_four += $d['TRYtutar'];
            $oncelikUSD_four += $d['USDtutar'];
        }
    }

    ?>
    <table class="table">
        <thead>
        <tr>
            <td class="text-right"></td>
            <td class="text-right">TL</td>
            <td class="text-right">USD</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-right"><i class="fal fa-star"></i></td>
            <td class="text-right"><?=FloatFormat($oncelikTRY_zero, 2)?></td>
            <td class="text-right"><?=FloatFormat($oncelikUSD_zero, 2)?></td>
        </tr>
        <tr>
            <td class="text-right kt-font-boldest" onclick="shortcutOdemeOncelik([1])"><i class="fas fa-star"></i></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikTRY_one, 2)?></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikUSD_one, 2)?></td>
        </tr>
        <tr>
            <td class="text-right kt-font-boldest" onclick="shortcutOdemeOncelik([2])"><i class="fas fa-star"></i><i class="fas fa-star"></i></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikTRY_two, 2)?></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikUSD_two, 2)?></td>
        </tr>
        <tr>
            <td class="text-right kt-font-boldest" onclick="shortcutOdemeOncelik([3])"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikTRY_three, 2)?></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikUSD_three, 2)?></td>
        </tr>
        <tr>
            <td class="text-right kt-font-boldest" onclick="shortcutOdemeOncelik([4])"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikTRY_four, 2)?></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikUSD_four, 2)?></td>
        </tr>
        <tr class="table-warning">
            <td class="text-right kt-font-boldest" onclick="shortcutOdemeOncelik([1,2,3,4])">ÖNCELİK TOPLAM</td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikTRY_four+$oncelikTRY_three+$oncelikTRY_two+$oncelikTRY_one, 2)?></td>
            <td class="text-right kt-font-boldest"><?=FloatFormat($oncelikUSD_four+$oncelikUSD_three+$oncelikUSD_two+$oncelikUSD_one, 2)?></td>
        </tr>
        </tbody>
    </table>
<? }


if ($action == 'odemeGetData') {
    odemeGetData(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function odemeGetData($id)
{
    global $CurrentFirm;

    if (empty($id)) {
        JsonResult('empty', 'Kayit secilmemis', 0);
    }
    else {
        $array = array('borcluUnvan' => '', 'alacakliUnvan' => '', 'tutar' => '');

        $dataFromText   = 'odm_odeme_takip oot ';
        $dataFromText  .= ' left join param_odm_borclusirketler pob on(oot.borclusirket_id=pob.id)';
        $dataFromText  .= ' left join param_odm_odemeyerleri poy on(oot.odemeyeri_id=poy.id)';
        $dataSelectText = 'pob.unvan as "borcluunvan", poy.unvan as "odemeyeriunvan", oot.tutar as "tutar"';

        $data = GetSingleRowDataFromTableWithSingleWhere($dataFromText, $dataSelectText,'oot.id=' . $id . ' AND oot.sirket_id=' . $CurrentFirm['id'], false);

        $array['borcluUnvan']   = $data['borcluunvan'];
        $array['alacakliUnvan'] = $data['odemeyeriunvan'];
        $array['tutar'] = $data['tutar'];
    }
    echo json_encode($array);
}


if ($action == 'odemeTakipWidget') {
    odemeTakipWidget();
}

function odemeTakipWidget()
{
    global $CurrentFirm, $DovizKuruUSD; ?>

    <div class="row">
        <div class="col-md-9">
            <!--begin:: istatistik chart -->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Şirkete Göre Borç Dağılımı <small>tarih aralıklı</small>
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a href="#" class="btn btn-label-success btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">Vade Tarihi</a>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <table class="table table-bordered table-sm derm-table">
                        <thead>
                        <tr>
                            <th>Şirket</th>
                            <th class="text-right">Ocak</th>
                            <th class="text-right">Subat</th>
                            <th class="text-right">Mart</th>
                            <th class="text-right">Nisan</th>
                            <th class="text-right">Mayis</th>
                            <th class="text-right">Haziran</th>
                            <th class="text-right">Temmuz</th>
                            <th class="text-right">Agustos</th>
                            <th class="text-right">Eylul</th>
                            <th class="text-right">Ekim</th>
                            <th class="text-right">Kasim</th>
                            <th class="text-right">Aralik</th>
                            <th class="text-right">TL Bu Ay</th>
                            <th class="text-right">TL Bu Yıl</th>
                            <th class="text-right">USD Bu Ay</th>
                            <th class="text-right">USD Bu Yıl</th>
                        </tr>
                        </thead>


                        <?
                        $selectedMode = "vade_tarih";
                        $selectedYear=(isset($_GET['year']) && is_numeric($_GET['year'])) ? $_GET['year'] : date('Y');
                        if($selectedYear==0) $selectedYear='0000';
                        $whStartDate = $selectedYear.'-01-01';
                        $whEndDate = $selectedYear.'-12-31';
                        $currentMonth = date('n');

                        $odemeIds = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'GROUP_CONCAT(distinct id order by id) as "ids"', ''.$selectedMode.' between "'.$whStartDate.'" and "'.$whEndDate.'"', false);

                        $toplamTutarTRY=0;
                        $toplamTutarUSD=0;
                        $firmalar=array();
                        if(!empty($odemeIds['ids'])){
                            //$odemeIdsTutarTRY = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'GROUP_CONCAT(distinct id order by id) as "ids"', ''.$selectedMode.' between "'.$whStartDate.'" and "'.$whEndDate.'" and parabirimi_id="1"', false);
                            //$odemeIdsTutarUSD = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'GROUP_CONCAT(distinct id order by id) as "ids"', ''.$selectedMode.' between "'.$whStartDate.'" and "'.$whEndDate.'" and parabirimi_id="2"', true);
                            $odemeIdsTutarTRY = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'IFNULL(GROUP_CONCAT(distinct id order by id),0) as "ids"', ''.$selectedMode.' between "'.$whStartDate.'" and "'.$whEndDate.'" and parabirimi_id="1"', false);
                            $odemeIdsTutarUSD = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'IFNULL(GROUP_CONCAT(distinct id order by id),0) as "ids"', ''.$selectedMode.' between "'.$whStartDate.'" and "'.$whEndDate.'" and parabirimi_id="2"', false);
                            $toplamTutarTRY = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'IFNULL(sum(tutar), 0) as "net"', 'id in ('.$odemeIdsTutarTRY['ids'].')', false);
                            $toplamTutarUSD = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'IFNULL(sum(tutar), 0) as "net"', 'id in ('.$odemeIdsTutarUSD['ids'].')', false);




                            $firmaIds = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'GROUP_CONCAT(distinct borclusirket_id order by borclusirket_id) as "ids"', 'id in ('.$odemeIds['ids'].')', false);
                            $firmalar = GetDataToTableWithSingleWhere('param_odm_borclusirketler', '*', 'sort_order', 'id in ('.$firmaIds['ids'].')', false);
                        }



                        $borcTutarAyTRY = array();
                        $borcTutarAyUSD = array();
                        ?>

                        <? foreach($firmalar as $firma){
                            for($ay=1; $ay<=12; $ay++){
                                if(!isset($borcTutarAyTRY[$ay]) || empty($borcTutarAyTRY[$ay])) $borcTutarAyTRY[$ay] = 0;
                                $ciroTRY[$firma['tag']][$ay] = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'ifnull(sum(tutar), 0) as "net"', 'id in ('.$odemeIdsTutarTRY['ids'].') and borclusirket_id='.$firma['id'].' and '.$selectedMode.' between "'.$selectedYear.'-'.$ay.'-01" and "'.$selectedYear.'-'.$ay.'-31"', false);
                                $borcTutarAyTRY[$ay] += $ciroTRY[$firma['tag']][$ay]['net'];


                                if(!isset($borcTutarAyUSD[$ay]) || empty($borcTutarAyUSD[$ay])) $borcTutarAyUSD[$ay] = 0;
                                $ciroUSD[$firma['tag']][$ay] = GetSingleRowDataFromTableWithSingleWhere('odm_odeme_takip', 'ifnull(sum(tutar), 0) as "net"', 'id in ('.$odemeIdsTutarUSD['ids'].') and borclusirket_id='.$firma['id'].' and '.$selectedMode.' between "'.$selectedYear.'-'.$ay.'-01" and "'.$selectedYear.'-'.$ay.'-31"', false);
                                $borcTutarAyUSD[$ay] += $ciroUSD[$firma['tag']][$ay]['net'];

                            }
                        }
                        ?>

                        <tbody>
                        <? $totalContMonthTRY=0;
                        $totalContMonthUSD=0;
                        $totalContTRY = 0;
                        $totalContUSD = 0;
                        $varFirmalar = array();
                        $varBorcTRY = array();
                        foreach($firmalar as $firma){
                            $varFirmalar[] = $firma['tag'];
                            $varBorcTRY[] = $ciroTRY[$firma['tag']][$currentMonth]['net'];

                            $totalAllMonthsTRY = 0;
                            $totalAllMonthsUSD = 0;
                            for($i=1; $i<=12 ; $i++){
                                $totalAllMonthsTRY+=$ciroTRY[$firma['tag']][$i]['net'];
                                $totalAllMonthsUSD+=$ciroUSD[$firma['tag']][$i]['net'];
                            }
                            ?>
                            <tr>
                                <th scope="row"><?=$firma['tag']?></th>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][1]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][2]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][3]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][4]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][5]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][6]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][7]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][8]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][9]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][10]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][11]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][12]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroTRY[$firma['tag']][$currentMonth]['net'], 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($totalAllMonthsTRY, 2)?> TL</span></td>
                                <td><span class="pull-right"><?=FloatFormat($ciroUSD[$firma['tag']][$currentMonth]['net'], 2)?> USD</span></td>
                                <td><span class="pull-right"><?=FloatFormat($totalAllMonthsUSD, 2)?> USD</span></td>
                            </tr>
                            <? $totalContMonthTRY+=$ciroTRY[$firma['tag']][$currentMonth]['net'];
                            $totalContTRY+=$totalAllMonthsTRY;
                            $totalContMonthUSD+=$ciroUSD[$firma['tag']][$currentMonth]['net'];
                            $totalContUSD+=$totalAllMonthsUSD;
                        } ?>
                        <?
                        $dataFirmalar = json_encode($varFirmalar);
                        $dataBorcTRY = json_encode($varBorcTRY);
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="13"><i>TOPLAM</i></th>
                            <th><span class="pull-right"><i><?=FloatFormat($totalContMonthTRY, 2)?> TL</i></span></th>
                            <th><span class="pull-right"><i><?=FloatFormat($totalContTRY, 2)?> TL</i></span></th>
                            <th><span class="pull-right"><i><?=FloatFormat($totalContMonthUSD, 2)?> USD</i></span></th>
                            <th><span class="pull-right"><i><?=FloatFormat($totalContUSD, 2)?> USD</i></span></th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <canvas id="myChart" width="100px" height="100px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">


        var deneme = <?=$dataFirmalar?>;

        var sayilar = <?=$dataBorcTRY?>;
    </script>
    <? require_once('../includes/widgets/chart-odeme.php'); ?>
<? }