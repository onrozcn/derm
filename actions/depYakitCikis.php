<?php
/**
 * Created by PhpStorm.
 * User: Onur
 * Date: 17.11.2018
 * Time: 12:33
 */
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

if ($action == 'yakitCikisTablo') {
	yakitCikisTablo(
		isset($_POST['page']) ? MysqlSecureText($_POST['page']) : 1,
		isset($_POST['all']) ? MysqlSecureText($_POST['all']) : 0,
		isset($_POST['tarihStartEnd']) && !empty($_POST['tarihStartEnd']) ? MysqlSecureText($_POST['tarihStartEnd']) : 'all',
		isset($_POST['tankId']) && !empty($_POST['tankId']) ? $_POST['tankId'] : 'all',
		isset($_POST['aracId']) && !empty($_POST['aracId']) ? $_POST['aracId'] : 'all',
		isset($_POST['teslimEden']) && !empty($_POST['teslimEden']) ? $_POST['teslimEden'] : 'all'
	);
}

function yakitCikisTablo($page, $all, $tarihStartEnd, $tankId, $aracId, $teslimEden)
{
	global $CurrentFirm;
	$tableItemCount = 75;
	$showPage = 3;
	$totalDataCount = GetRowCountWithSingleWhere('dep_yakit_cikis', 'sirket_id=' . $CurrentFirm['id']);
	if ($all == 1) {
		$tableItemCount = $totalDataCount;
		$page = 1;
	}

	$dataFromText = 'dep_yakit_cikis dyc ';
	$dataFromText .= ' left join param_dep_araclar pda on(dyc.arac_id=pda.id)';
	$dataFromText .= ' left join users u on(dyc.teslim_eden_id=u.id)';
	$dataFromText .= ' left join param_dep_tanklar pdt on(dyc.tank_id=pdt.id)';
	$dataSelectText = 'dyc.*, pda.plaka as "arac_plaka", pda.marka as "arac_marka", pda.model as "arac_model" , pda.calctuketim as "calctuketim", u.name as "userName", u.surname as "userSurname", pdt.kisa_isim as "tank_tag"';


	$dataWhereText = '1=1 AND dyc.sirket_id=' . $CurrentFirm['id'];
	if ($tarihStartEnd != 'all') {
		$tarihStartEnd = dateTimeRangeDateExplode($tarihStartEnd);
		if ($tarihStartEnd != 'all') $dataWhereText .= ' and tarih between "' . $tarihStartEnd[0] . '" and "' . $tarihStartEnd[1] . '"';
	}


	if ($tankId != 'all') $dataWhereText .= ' and tank_id=' . $tankId . '';
	if ($aracId != 'all') $dataWhereText .= ' and arac_id=' . $aracId . '';
	if ($teslimEden != 'all') $dataWhereText .= ' and teslim_eden_id=' . $teslimEden . '';

	$dataList = GetListDataFromTableWithSingleWhereAndLimit($dataFromText, $dataSelectText, 'tarih desc, id desc', $dataWhereText, $page, $tableItemCount, false);

	if ($totalDataCount <= 0) { ?>
        <div class="alert alert-primary">
            <div class="alert-text"><i class="fal fa-info-circle"></i> <strong>Kayıt Yok!</strong> Veritabanında hiçbir kayıt olmadığından tablo oluşturulamıyor.</div>
        </div>
	<?php }
	else {
		pagination($page, $totalDataCount, $tableItemCount, $showPage, 'yakitCikisTablo', $all, true);
		?>
		<div class="row">
            <?UserListByPermission('TELEGRAMdepYakit', true);

            ?>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered table-sm derm-table" id="yakitCikisTable">
						<thead>
						<tr>
							<th>#</th>
							<th>Tank</th>
							<th>Tarih</th>
							<th>Araç</th>
							<th>İlk KM</th>
							<th>Son KM</th>
							<th>Litre</th>
							<th>Tüketim</th>
							<th>Teslim Eden</th>
							<th>Açıklama</th>
						</tr>
						</thead>
						<tbody><?php
						$counter = ($page * $tableItemCount) - $tableItemCount + 1;
						foreach ($dataList as $data) {
							?>
							<tr>
							<td>
								<?php echo $counter; ?>
                                <div class="dropdown dropdown-inline">
                                    <button type="button" class="btn derm-btn-td btn-clean btn-icon btn-sm btn-icon-md" data-toggle="dropdown"><i class="flaticon-more-1"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:;" onclick="yakitCikisDuzenle(<?= $data['id'] ?>);"><i class="la la-pencil"></i> Düzenle</a>
                                        <a class="dropdown-item" href="javascript:;" onclick="yakitFis();"><i class="fal fa-fw fa-receipt"></i> Fiş</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:;" onclick="yakitCikisSil(<?= $data['id'] ?>);"><i class="la la-trash"></i> Sil</a>
                                    </div>
                                </div>
							</td>
                            <td><?php echo $data['tank_tag'] ?></td>
                            <td><?php echo JsSlashDateFixTr($data['tarih']) ?></td>
							<td><?php echo $data['arac_plaka'] . ' - ' . $data['arac_marka'] . ' ' . $data['arac_model'] ?></td>
							<td align="right"><?= FloatFormat($data['ilk_km'], 0) ?></td>
							<td align="right"><?= FloatFormat($data['son_km'], 0) ?></td>
							<td align="right"><?= FloatFormat($data['litre'], 2) ?></td>
							<td align="right"><?= $data['calctuketim'] == 1 ? FloatFormat($data['litre'] / ($data['son_km'] - $data['ilk_km']) * 100, 2) : ''  ?></td>
							<td><?php echo $data['userName'][0] . '.' . $data['userSurname'] ?></td>
							<td><?php echo $data['aciklama'] ?></td>
							</tr><?php $counter++;
						}
						?></tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
		pagination($page, $totalDataCount, $tableItemCount, $showPage, 'yakitCikisTablo', $all, true);
	}
}

if ($action == 'yakitCikisGetir') {
	yakitCikisGetir(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
	);
}

function yakitCikisGetir($id)
{
	global $CurrentFirm;

	$array = array('result' => 'fail', 'id' => $id, 'tank_id' => '', 'tarih' => '', 'arac_id' => '', 'ilk_km' => '', 'son_km' => '', 'litre' => '', 'teslim_eden_id' => '', 'aciklama' => '');

	if (empty($id)) {
		$array['result'] = 'empty';
	}
	else {
		$data = GetSingleDataFromTableWithSingleWhere('dep_yakit_cikis', 'id=' . $id . ' AND sirket_id=' . $CurrentFirm['id']);
		if (empty($data)) {
			$array['result'] = 'fail';
		}
		else {
			$array['result'] = 'ok';
            $array['tank_id'] = $data['tank_id'];
            $array['tarih'] = JsSlashDateFixTr($data['tarih']);
			$array['arac_id'] = $data['arac_id'];
			$array['ilk_km'] = $data['ilk_km'];
			$array['son_km'] = $data['son_km'];
			$array['litre'] = $data['litre'];
			$array['teslim_eden_id'] = $data['teslim_eden_id'];
			$array['aciklama'] = $data['aciklama'];
		}
	}

	echo json_encode($array);
}


if ($action == 'yakitCikisKaydet') {
	yakitCikisKaydet(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
		isset($_POST['tank_id']) ? MysqlSecureText($_POST['tank_id']) : 0,
		isset($_POST['tarih']) && isItDate($_POST['tarih']) ? JsSlashDateFix(MysqlSecureText($_POST['tarih'])) : '0000-00-00',
		isset($_POST['arac_id']) ? MysqlSecureText($_POST['arac_id']) : '',
		isset($_POST['ilk_km']) ? MysqlSecureText($_POST['ilk_km']) : 0,
		isset($_POST['son_km']) ? MysqlSecureText($_POST['son_km']) : 0,
		isset($_POST['litre']) ? MysqlSecureText($_POST['litre']) : 0,
		isset($_POST['teslim_eden_id']) ? MysqlSecureText($_POST['teslim_eden_id']) : '',
		isset($_POST['aciklama']) ? MysqlSecureText($_POST['aciklama']) : ''
	);
}

function yakitCikisKaydet($id, $tank_id, $tarih, $arac_id, $ilk_km, $son_km, $litre, $teslim_eden_id, $aciklama)
{
	global $CurrentUser, $CurrentFirm, $setting;

    $tankData = GetSingleDataFromTable('param_dep_tanklar', $tank_id);

	if ($tarih == '0000-00-00' || empty($tank_id)|| empty($arac_id) || !isset($son_km) || empty($litre) || empty($teslim_eden_id)) {
        $array['result'] = 'empty';
        $array['title'] = 'Uyarı';
        $array['message'] = 'Lütfen zorunla alanları doldurun';
        $array['selector'] = 'DepoHighChart' . $tank_id;
        $array['tank_id'] = $tank_id;
        echo json_encode($array);
//		JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
	}
	else if ($son_km < $ilk_km) {
        $array['result'] = 'empty';
        $array['title'] = 'Uyarı';
        $array['message'] = 'Son KM, ilk KM den küçük olamaz';
        $array['selector'] = 'DepoHighChart' . $tank_id;
        $array['tank_id'] = $tank_id;
        echo json_encode($array);
//		JsonResult('empty', 'Son KM, ilk KM den küçük olamaz', $id);
	}
	else {
        $dataUserId = $CurrentUser['id'];
		$dataDatetime = date('Y-m-d H:i:s', time());

        /* ----- TELEGRAM ----- */
        $getArac = GetSingleDataFromTable('param_dep_araclar', $arac_id);
        $getTeslimEden = GetSingleDataFromTable('users', $teslim_eden_id);
        $giris = GetRowSumsWithSingleWhere('dep_yakit_giris', 'litre', 'sirket_id=' . $CurrentFirm['id'] . ' AND tank_id=' . $tank_id);
        $cikis = GetRowSumsWithSingleWhere('dep_yakit_cikis', 'litre', 'sirket_id=' . $CurrentFirm['id'] . ' AND tank_id=' . $tank_id);
        $kalan = $giris - $cikis - DotFix($litre);

        $telegram_icon = "\xE2\x9B\xBD";
        $telegram_text  = "dERM Bilgilendirme - " . $CurrentFirm['tag'] . "\n" ;
        $telegram_text .= "$telegram_icon Yakıt Sistemi \n";
        $telegram_text .= "Tarih: " . DateFormat($tarih, 'd/m/Y') . "\n";
        $telegram_text .= "Plaka: " . $getArac['plaka'] . "\n";
        $telegram_text .= "İlk KM: " . FloatFormat($ilk_km, 0) . "\n";
        $telegram_text .= "Son KM: " . FloatFormat($son_km, 0) . "\n";
        $telegram_text .= "Litre: " . $litre . "\n";
        if ($getArac['calctuketim']==1) {
            $tuketim = FloatFormat($litre / ($son_km - $ilk_km) * 100, 2);
            $telegram_text .= "Tüketim: " . $tuketim  . "L/100 KM \n";
        }


        if ($tankData['tank_hesapla'] == 1) {
            $telegram_text .= "Tank:" . FloatFormat($tankData['kapasite'], 0) . "/" . FloatFormat($kalan, 0) . " L \n";
        }
        //$telegram_text .= "Tank:" . FloatFormat($CurrentFirm['tank_kapasite'], 0) . "/" . FloatFormat($kalan, 0) . " L \n";
        $telegram_text .= "Teslim Eden: " . $getTeslimEden['name'] . ' '. $getTeslimEden['surname'] . "\n";
        if (!empty($aciklama)) { $telegram_text .= "Açıklama: $aciklama"; }

        if ( $setting['telegram_send_notification'] == true ) {
            $users = UserListByPermission('TELEGRAMdepYakit', true);
            foreach ($users as $user) {
                TelegramSendMessage($setting['telegram_token'], $user['telegram_chatid'], 'sendMessage', $telegram_text);
            }
        }

//    $sendTelegram = array(
//        TelegramSendMessage($setting['telegram_token'], '1640474785', 'sendMessage', $telegram_text), //onur
//        TelegramSendMessage($setting['telegram_token'], '2006282778', 'sendMessage', $telegram_text), // ferhat
//    );
        /* ----- TELEGRAM ----- */

		if ($id > 0) {
			if (UpdateTable(
				'dep_yakit_cikis',
				array('sirket_id', 'tank_id', 'tarih', 'arac_id', 'ilk_km', 'son_km', 'litre', 'teslim_eden_id', 'aciklama', 'updateUserId', 'updateDatetime'),
				array($CurrentFirm['id'], $tank_id, $tarih, $arac_id, $ilk_km, $son_km, DotFix($litre), $teslim_eden_id, $aciklama, $dataUserId, $dataDatetime),
				'id', $id)) {

                $array['result'] = 'ok';
                $array['title'] = 'Başarılı';
                $array['message'] = 'Kayıt düzenlendi';
                $array['selector'] = 'DepoHighChart' . $tank_id;
                $array['tank_id'] = $tank_id;
                echo json_encode($array);

//				JsonResult('ok', 'Kayit Duzenlendi', $id);
			}
			else {
				JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
			}
		}
		else {
			if (AddToTable(
				'dep_yakit_cikis',
				array('sirket_id', 'tank_id', 'tarih', 'arac_id', 'ilk_km', 'son_km', 'litre', 'teslim_eden_id', 'aciklama', 'recordUserId', 'updateUserId', 'recordDatetime'),
				array($CurrentFirm['id'], $tank_id, $tarih, $arac_id, $ilk_km, $son_km, DotFix($litre), $teslim_eden_id, $aciklama, $dataUserId, $dataUserId, $dataDatetime),
				false)) {

                $array['result'] = 'ok';
                $array['title'] = 'Başarılı';
                $array['message'] = 'Kayıt eklendi';
                $array['selector'] = 'DepoHighChart' . $tank_id;
                $array['tank_id'] = $tank_id;
                echo json_encode($array);
//				JsonResult('ok', 'Kayıt eklendi', 0);
			}
			else {

                $array['result'] = 'fail';
                $array['title'] = 'Hata';
                $array['message'] = 'İşlem sırasında hata oluştu';
                $array['selector'] = 'DepoHighChart' . $tank_id;
                $array['tank_id'] = $tank_id;
                echo json_encode($array);
//				JsonResult('fail', 'İşlem sırasında hata oluştu', $id);

			}
		}
	}
}

if ($action == 'yakitCikisSil') {
	yakitCikisSil(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
	);
}

function yakitCikisSil($id)
{
	if (empty($id)) {
        $array['result'] = 'empty';
        $array['title'] = 'Uyarı';
        $array['message'] = 'Kayıt seçilmemiş';
        echo json_encode($array);
//		JsonResult('empty', 'Kayit secilmemis', 0);
	}
	else {
        $getData = GetSingleDataFromTable('dep_yakit_cikis', $id);
        $tank_id = $getData['tank_id'];
		if (DeleteById('dep_yakit_cikis', 'id', $id, false)) {
            $array['result'] = 'ok';
            $array['title'] = 'Başarılı';
            $array['message'] = 'Kayıt silindi';
            $array['selector'] = 'DepoHighChart' . $tank_id;
            $array['tank_id'] = $tank_id;
            echo json_encode($array);
//			JsonResult('ok', 'Silindi', 0);
		}
		else {
            $array['result'] = 'fail';
            $array['title'] = 'Hata';
            $array['message'] = 'İşlem sırasında hata oluştu';
            $array['selector'] = 'DepoHighChart' . $tank_id;
            $array['tank_id'] = $tank_id;
            echo json_encode($array);
//				JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
		}
	}
}

if ($action == 'aracIdSonKmFind') {
	aracIdSonKmFind(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
	);
}

function aracIdSonKmFind($id)
{
	$array = array('result' => 'fail', 'value' => '');
	if (empty($id)) {
		$array['result'] = 'select';
		$array['value'] = '';
	}
	else {
		//$query = GetSingleRowDataFromTableWithSingleWhere('dep_yakit_cikis', 'MAX(son_km) as son_km', 'arac_id=' . $id);
        $query = GetSingleDataFromTableWithSingleWhere('dep_yakit_cikis', 'arac_id=' . $id . ' ORDER BY id DESC LIMIT 1');
		$checkMuhtelif = GetSingleDataFromTableWithSingleWhere('param_dep_araclar', 'id=' . $id);
		if ($checkMuhtelif['muhtelif'] == 0) {
            if (isset($query['son_km']) && !empty($query['son_km'])) {
                $array['result'] = 'ok';
                $array['value'] = $query['son_km'];
            }
            else if (empty($query['son_km'])) {
                $array['result'] = 'empty';
                $array['value'] = '0';
            }
        } else {
            $array['result'] = 'muhtelif';
            $array['value'] = 0;
        }
	}
	echo json_encode($array);
}