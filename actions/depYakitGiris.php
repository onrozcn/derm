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

if ($action == 'yakitGirisTablo') {
	yakitGirisTablo(
		isset($_POST['page']) ? MysqlSecureText($_POST['page']) : 1,
		isset($_POST['all']) ? MysqlSecureText($_POST['all']) : 0
	);
}

function yakitGirisTablo($page, $all = 0)
{
	global $CurrentFirm;

	$tableItemCount = 25;
	$showPage = 3;
	$totalDataCount = GetRowCountWithSingleWhere('dep_yakit_giris', 'sirket_id=' . $CurrentFirm['id']);
	if ($all == 1) {
		$tableItemCount = $totalDataCount;
		$page = 1;
	}

	$dataFromText = 'dep_yakit_giris dyg ';
	$dataFromText .= ' left join users u on(dyg.teslim_alan_id=u.id)';
	$dataFromText .= ' left join param_dep_tanklar pdt on(dyg.tank_id=pdt.id)';
	$dataSelectText = 'dyg.*, u.name as "teslimAlanAd", u.surname as "teslimAlanSoyad", pdt.kisa_isim as "tank_tag"';

	$dataList = GetListDataFromTableWithSingleWhereAndLimit($dataFromText, $dataSelectText, 'tarih desc', 'dyg.sirket_id=' . $CurrentFirm['id'], $page, $tableItemCount, false);

	if ($totalDataCount <= 0) { ?>
        <div class="alert alert-primary">
            <div class="alert-text"><i class="fal fa-info-circle"></i> <strong>Kayıt Yok!</strong> Veritabanında hiçbir kayıt olmadığından tablo oluşturulamıyor.</div>
        </div>
	<?php }
	else {
		pagination($page, $totalDataCount, $tableItemCount, $showPage, 'yakitGirisTablo', $all, true);
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive text-nowrap" id="yakitGirisTablo">
					<table class="table table-bordered table-sm derm-table">
						<thead>
						<tr>
							<th>#</th>
							<th>Tank</th>
							<th>Tarih</th>
							<th>Plaka</th>
							<th>Litre</th>
							<th>Reel Litre</th>
							<th>Firma</th>
							<th>Fiyat</th>
							<th>İskonto</th>
							<th>Teslim Alan</th>
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
                                        <a class="dropdown-item" href="javascript:;" onclick="yakitGirisDuzenle(<?php echo $data['id'] ?>);"><i class="la la-pencil"></i> Düzenle</a>
                                        <a class="dropdown-item" href="javascript:;" onclick="yakitFis();"><i class="fal fa-fw fa-receipt"></i> Fiş</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:;" onclick="yakitGirisSil(<?php echo $data['id'] ?>);"><i class="la la-trash"></i> Sil</a>
                                    </div>
                                </div>

							</td>
                            <td><?php echo $data['tank_tag'] ?></td>
                            <td><?php echo JsSlashDateFixTr($data['tarih']) ?></td>
							<td><?php echo $data['plaka'] ?></td>
							<td align="right"><?php echo FloatFormat($data['litre'], 2) ?></td>
							<td align="right"><?php echo FloatFormat($data['litre_reel'], 2) ?></td>
							<td><?php echo $data['firma'] ?></td>
							<td align="right"><?php echo FloatFormat($data['fiyat'], 2) ?> ₺</td>
							<td align="right">% <?php echo FloatFormat($data['iskonto'], 2) ?></td>
							<td><?php echo $data['teslimAlanAd'] . ' ' . $data['teslimAlanSoyad'] ?></td>
							</tr><?php $counter++;
						}
						?></tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
		pagination($page, $totalDataCount, $tableItemCount, $showPage, 'yakitGirisTablo', $all, true);
	}
}

if ($action == 'yakitGirisGetir') {
	yakitGirisGetir(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
	);
}

function yakitGirisGetir($id)
{
	global $CurrentFirm;

	$array = array('result' => 'fail', 'id' => $id, 'tank_id' => '', 'tarih' => '', 'firma' => '', 'plaka' => '', 'litre' => '', 'litre_reel' => '', 'fiyat' => '', 'iskonto' => '', 'teslim_alan_id' => '');

	if (empty($id)) {
		$array['result'] = 'empty';
	}
	else {
		$data = GetSingleDataFromTableWithSingleWhere('dep_yakit_giris', 'id=' . $id . ' AND sirket_id=' . $CurrentFirm['id']);
		if (empty($data)) {
			$array['result'] = 'fail';
		}
		else {
			$array['result'] = 'ok';
            $array['tank_id'] = $data['tank_id'];
            $array['tarih'] = JsSlashDateFixTr($data['tarih']);
			$array['firma'] = $data['firma'];
			$array['plaka'] = $data['plaka'];
			$array['litre'] = $data['litre'];
			$array['litre_reel'] = $data['litre_reel'];
			$array['fiyat'] = $data['fiyat'];
			$array['iskonto'] = $data['iskonto'];
			$array['teslim_alan_id'] = $data['teslim_alan_id'];
		}
	}

	echo json_encode($array);
}


if ($action == 'yakitGirisKaydet') {
	yakitGirisKaydet(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
		isset($_POST['tank_id']) ? MysqlSecureText($_POST['tank_id']) : 0,
		isset($_POST['tarih']) && isItDate($_POST['tarih']) ? JsSlashDateFix(MysqlSecureText($_POST['tarih'])) : '0000-00-00',
		isset($_POST['firma']) ? MysqlSecureText($_POST['firma']) : '',
		isset($_POST['plaka']) ? MysqlSecureText($_POST['plaka']) : '',
		isset($_POST['litre']) ? MysqlSecureText($_POST['litre']) : 0,
		isset($_POST['litre_reel']) ? MysqlSecureText($_POST['litre_reel']) : 0,
		isset($_POST['fiyat']) ? MysqlSecureText($_POST['fiyat']) : 0,
		isset($_POST['iskonto']) ? MysqlSecureText($_POST['iskonto']) : 0,
		isset($_POST['teslim_alan_id']) ? MysqlSecureText($_POST['teslim_alan_id']) : 0
	);
}

function yakitGirisKaydet($id, $tank_id, $tarih, $firma, $plaka, $litre, $litre_reel, $fiyat, $iskonto, $teslim_alan_id)
{
	global $CurrentUser, $CurrentFirm;
	//if ($tarih == '0000-00-00' || empty($firma) || empty($plaka) || empty($litre) || empty($litre_reel) || empty($fiyat) || empty($iskonto) || empty($teslim_alan_id)) {
    if (empty($tank_id)) {
		JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
	}
	else {
		$dataUserId = $CurrentUser['id'];
		$dataDatetime = date('Y-m-d H:i:s', time());
		if ($id > 0) {
			if (UpdateTable(
				'dep_yakit_giris',
				array('sirket_id', 'tank_id', 'tarih', 'firma', 'plaka', 'litre', 'litre_reel', 'fiyat', 'iskonto', 'teslim_alan_id', 'updateUserId', 'updateDatetime'),
				array($CurrentFirm['id'], $tank_id, $tarih, $firma, $plaka, DotFix($litre), DotFix($litre_reel), DotFix($fiyat), DotFix($iskonto), $teslim_alan_id, $dataUserId, $dataDatetime),
				'id', $id)) {
				JsonResult('ok', 'Kayit Duzenlendi', $id);
			}
			else {
				JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
			}
		}
		else {
			if (AddToTable(
				'dep_yakit_giris',
				array('sirket_id', 'tank_id', 'tarih', 'firma', 'plaka', 'litre', 'litre_reel', 'fiyat', 'iskonto', 'teslim_alan_id', 'recordUserId', 'updateUserId', 'recordDatetime', 'updateDatetime'),
				array($CurrentFirm['id'], $tank_id, $tarih, $firma, $plaka, DotFix($litre), DotFix($litre_reel), DotFix($fiyat), DotFix($iskonto), $teslim_alan_id, $dataUserId, $dataUserId, $dataDatetime, $dataDatetime),
				false)) {
				JsonResult('ok', 'Kayıt eklendi', 0);
			}
			else {
				JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
			}
		}
	}
}

if ($action == 'yakitGirisSil') {
	yakitGirisSil(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
	);
}

function yakitGirisSil($id)
{
	if (empty($id)) {
		JsonResult('empty', 'Kayit secilmemis', 0);
	}
	else {
		if (DeleteById('dep_yakit_giris', 'id', $id, false)) {
			JsonResult('ok', 'Silindi', 0);
		}
		else {
			JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
		}
	}
}