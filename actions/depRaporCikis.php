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



if ($action == 'DepoRaporCikisTabloGetir') {
    DepoRaporCikisTabloGetir(
        isset($_POST['type']) ? MysqlSecureText($_POST['type']) : 'screen',
        isset($_POST['page']) ? MysqlSecureText($_POST['page']) : 1,
        isset($_POST['start_date']) && !empty($_POST['start_date']) ? Html5DateTimeLocalDecode($_POST['start_date']) : date("Y-m-01"),
        isset($_POST['end_date']) && !empty($_POST['end_date']) ? Html5DateTimeLocalDecode($_POST['end_date']) : date("Y-m-d"),
        isset($_POST['status']) ? MysqlSecureText($_POST['status']) : 1
    );
}

function DepoRaporCikisTabloGetir($type, $page, $start_date, $end_date, $status)
{
    global $CurrentFirm, $CurrentUser;


    $status == 'all' ? $statusWhereText='(pda.active=1 OR pda.active=0)' : $statusWhereText='pda.active=' . $status;

    $aracListe = GetListDataFromTableWithSingleWhere('param_dep_araclar pda', 'pda.sirket_id, pda.id, pda.plaka', 'id', 'sirket_id=' . $CurrentFirm['id'] . ' AND ' . $statusWhereText, false);
    $tableItemCount = 500;

    $date_start_date = new DateTime($start_date);
    $date_end_date = new DateTime($end_date);
    $date_interval = DateInterval::createFromDateString('1 day');
    // $date_period = new DatePeriod($date_start_date, $date_interval, $date_end_date); if use foreach


    if ($date_start_date <= $date_end_date) {
        if ($type == 'screen') { ?>

            <div class="kt-separator kt-separator--fit"></div>

            <div class="row">
                <div class="col">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-sm btn-success" onclick="DepoRaporCikisTabloGetir('xlsx', 1, '<?=$start_date?>', '<?=$end_date?>')">
                            <i class="fas fa-file-excel"></i>Excel İndir</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="DepoRaporCikisTabloGetir('print', 1, '<?=$start_date?>', '<?=$end_date?>')">
                            <i class="fas fa-print"></i>Yazdır</button>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered derm-table">
                            <thead>
                            <th>Tarih</th>
                            <? foreach ($aracListe as $al) { ?>
                                <th><?=$al['plaka']?></th>
                            <? } ?>
                            <th>Toplam</th>
                            </thead>
                            <tbody>
                            <?
                            for($dt = $date_start_date; $dt <= $date_end_date; $dt->modify('+1 day')){
                                //foreach ($date_period as $dt) {
                                $arac_gun_litre_toplam = 0;
                                $dataWhereTextArac   = 'pda.sirket_id=' . $CurrentFirm['id'] . ' AND ' . $statusWhereText;
                                $dataFromTextArac    = 'param_dep_araclar pda ';
                                $dataOrderTextArac   = 'pda.id';
                                $dataSelectTextArac  = 'pda.*';
                                $dataSelectTextArac .= ' ,(select ROUND(IFNULL(sum(dyc.litre), 0), 0) FROM dep_yakit_cikis dyc WHERE dyc.arac_id=pda.id AND dyc.tarih BETWEEN "' . $dt->format("Y-m-d") . '" AND "' . $dt->format("Y-m-d") . '") AS "arac_gun_litre"';
                                $dataListArac        = GetListDataFromTableWithSingleWhereAndLimit($dataFromTextArac, $dataSelectTextArac, $dataOrderTextArac, $dataWhereTextArac, $page, $tableItemCount, false);
                                ?>
                                <tr>
                                    <td><?=DateFormat($dt->format("Y-m-d"), 'd/m/Y', 'tr')?></td>
                                    <? foreach ($dataListArac as $dla) {
                                        $arac_gun_litre_toplam += $dla['arac_gun_litre']; ?>
                                        <td align="right"><?=$dla['arac_gun_litre']?></td>
                                    <? } ?>
                                    <td align="right"><?=$arac_gun_litre_toplam?></td>
                                </tr>
                            <? }
                            $dataSelectTextAracToplam  = 'pda.*';
                            $dataSelectTextAracToplam .= ' ,(select ROUND(IFNULL(sum(dyc.litre), 0), 0) FROM dep_yakit_cikis dyc WHERE dyc.arac_id=pda.id AND dyc.tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '") AS "arac_plaka_litre"';
                            $dataListAracToplam        = GetListDataFromTableWithSingleWhereAndLimit($dataFromTextArac, $dataSelectTextAracToplam, $dataOrderTextArac, $dataWhereTextArac, $page, $tableItemCount, false);
                            ?>
                            <tr>
                                <td>Toplam</td>
                                <?
                                $arac_plaka_litre_toplam = 0;
                                foreach ($dataListAracToplam as $dlt) {
                                    $arac_plaka_litre_toplam += $dlt['arac_plaka_litre']; ?>
                                    <td align="right"><?=$dlt['arac_plaka_litre']?></td>
                                <? } ?>
                                <td align="right"><?=$arac_plaka_litre_toplam?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <? } else if ($type=='xlsx' || $type=='print') {

            $setCreator = $CurrentUser['name'] . ' ' . $CurrentUser['surname'];
            $setCreatorInitial = $CurrentUser['initial'];
            $setLastModifiedBy = $CurrentUser['name'] . ' ' . $CurrentUser['surname'];
            $setTitle = 'dERM Report-Depo Yakıt Çıkış';
            $setSubject = 'dERM Report-Depo Yakıt Çıkış';
            $setDescription = 'dERM Report-Depo Yakıt Çıkış';
            $setKeywords = 'dERM Report-Depo Yakıt Çıkış';
            $setCategory = 'dERM Report-Depo Yakıt Çıkış';
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
            //$spreadsheet->getActiveSheet()->setAutoFilter('A1:O1');


            // Add header
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Tarih');
            $countColumn = 'B';

            foreach ($aracListe as $al) {
                $spreadsheet->getActiveSheet()->setCellValue($countColumn . '1', $al['plaka']);
                $countColumn++;
            }

            $rowActive = 2;




            $countColumn = 'B';
            for($dt = $date_start_date; $dt <= $date_end_date; $dt->modify('+1 day')) {
                //foreach ($date_period as $dt) {
                $arac_gun_litre_toplam = 0;
                $dataWhereTextArac   = '1=1 AND pda.active=1 AND pda.sirket_id=' . $CurrentFirm['id'];
                $dataFromTextArac    = 'param_dep_araclar pda ';
                $dataOrderTextArac   = 'pda.id';
                $dataSelectTextArac  = 'pda.*';
                $dataSelectTextArac .= ' ,(select ROUND(IFNULL(sum(dyc.litre), 0), 0) FROM dep_yakit_cikis dyc WHERE dyc.arac_id=pda.id AND dyc.tarih BETWEEN "' . $dt->format("Y-m-d") . '" AND "' . $dt->format("Y-m-d") . '") AS "arac_gun_litre"';
                $dataListArac        = GetListDataFromTableWithSingleWhereAndLimit($dataFromTextArac, $dataSelectTextArac, $dataOrderTextArac, $dataWhereTextArac, $page, $tableItemCount, false);


                $spreadsheet->getActiveSheet()->setCellValue("A$rowActive", DateFormat($dt->format("Y-m-d"), 'd/m/Y', 'tr'));
                foreach ($dataListArac as $dla) {
                    $arac_gun_litre_toplam += $dla['arac_gun_litre'];
                    $spreadsheet->getActiveSheet()->setCellValue($countColumn . '' . $rowActive, $dla['arac_gun_litre']);
                    $countColumn++;
                }
                $arac_gun_litre_toplam;
                $rowActive++;
                $countColumn = 'B';
            }

            // Calculate Rows
            $rowLast = $spreadsheet->getActiveSheet()->getHighestRow();

            // Set column widths
            foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }



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

        }
    } else { ?>
        <div class="alert alert-warning" role="alert">
            <strong>Hata! </strong> Başlangıç tarihi, bitiş tarihinden küçük olamaz.
        </div>
    <? }



}

if ($action == 'GuvenlikGirisCikisTabloGetir') {
    GuvenlikGirisCikisTabloGetir(
        isset($_POST['type']) ? MysqlSecureText($_POST['type']) : 'screen',
        isset($_POST['page']) ? MysqlSecureText($_POST['page']) : 1,
        isset($_POST['start_date']) && !empty($_POST['start_date']) ? Html5DateTimeLocalDecode($_POST['start_date']) : date("Y-m-d 00:00:00"),
        isset($_POST['end_date']) && !empty($_POST['end_date']) ? Html5DateTimeLocalDecode($_POST['end_date']) : date("Y-m-d 23:59:59")
    );
}

function GuvenlikGirisCikisTabloGetir($type, $page, $start_date, $end_date)
{
    /* Arac Turler
     * 1- Misafir
     * 2- Sirket
     * 3- Cop Kamyonu
     * 3- Hammadde Kamyonu */

    global $CurrentFirm, $CurrentUser;
    $tableItemCount = 200;

    $dataWhereText  = 'agc.sirket_id=' . $CurrentFirm['id'];
    $dataWhereText .= ' AND agc.giris_tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
    $dataFromText   = 'gvn_aracgiriscikis agc ';
    $dataFromText  .= '';
    $dataSelectText  = 'agc.*';
    $dataSelectText .= ' ,CASE agc.arac_tur WHEN 1 THEN "Misafir" WHEN 2 THEN "Şirket" WHEN 3 THEN "Çöp" WHEN 4 THEN "Hammadde" END AS arac_tur_text';
    $dataSelectText .= ' ,CASE agc.cop_saha WHEN 1 THEN "Kaklık" WHEN 2 THEN "Kocabaş" WHEN 2 THEN "Diğer" END AS cop_saha_text';
    $dataOrderText  = 'id DESC';
    $dataList = GetListDataFromTableWithSingleWhereAndLimit($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, $page, $tableItemCount, false);

    $dataWhereTextArac   = 'agc.sirket_id=' . $CurrentFirm['id'] . ' AND (agc.arac_tur=1 OR agc.arac_tur=2)';
    $dataWhereTextArac  .= ' AND agc.giris_tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
    $dataFromTextArac    = 'gvn_aracgiriscikis agc ';
    $dataFromTextArac   .= '';
    $dataSelectTextArac  = 'agc.*';
    $dataSelectTextArac .= ' ,CASE agc.arac_tur WHEN 1 THEN "Misafir" WHEN 2 THEN "Şirket" WHEN 3 THEN "Çöp" WHEN 4 THEN "Hammadde" END AS arac_tur_text';
    $dataOrderTextArac   = 'id DESC';
    $dataListArac        = GetListDataFromTableWithSingleWhereAndLimit($dataFromTextArac, $dataSelectTextArac, $dataOrderTextArac, $dataWhereTextArac, $page, $tableItemCount, false);



    if ($type == 'screen') {
        $perColId = '2%';
        $perColGiris = '10%';
        $perColCikis = '10%';
        $perColSure = '6%';               // 65
        $perColPlaka = '6%';
        $perColFirma = '10%';
        $perColAdSoyad = '9%';

        $perColTur = '24%';               // 24


        $perColFisNo = '8%';
        $perColKm = '8%';                 // 24
        $perColCopSaha = '8%';

        $perColOcak = '12%';
        $perColTarti1 = '4%';             // 24
        $perColTarti2 = '4%';
        $perColTartiNet = '4%';



        $perColAciklama = '10%';          // 11
        $perColIslem = '13%';
        ?>

        <div class="kt-separator kt-separator--fit"></div>
        <? if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisExport'))) { ?>
        <div class="row">
            <div class="col">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-sm btn-success" onclick="GuvenlikGirisCikisTabloGetir('xlsx', 1, '<?=$start_date?>', '<?=$end_date?>')">
                        <i class="fas fa-file-excel"></i>Excel İndir</button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="GuvenlikGirisCikisTabloGetir('print', 1, '<?=$start_date?>', '<?=$end_date?>')">
                        <i class="fas fa-print"></i>Yazdır</button>
                </div>
            </div>
        </div>
        <? } ?>

        <div class="row">
            <div class="col-12">
                <h3 class="text-right pb-2">Araç Hareketleri / <?=count($dataList)?></h3>
                <div class="table-responsive">
                    <table class="table table-bordered derm-table" style="font-size: 13px;">
                        <thead>
                        <tr>
                            <th width="<?=$perColId?>">#</th>
                            <th width="<?=$perColGiris?>">Giriş Tarih</th>
                            <th width="<?=$perColGiris?>">Çıkış Tarih</th>
                            <th width="<?=$perColSure?>">Süre</th>
                            <th width="<?=$perColPlaka?>">Plaka</th>
                            <th width="<?=$perColFirma?>">Firma</th>
                            <th width="<?=$perColAdSoyad?>">Ad Soyad</th>
                            <th width="<?=$perColTur?>">Tür</th>
                            <th width="<?=$perColAciklama?>">Açıklama</th>
                            <th width="<?=$perColIslem?>">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($dataListArac as $data) { $data['cikis_tarih']=='0000-00-00 00:00:00'?$satirRenk=' bg-warning':$satirRenk='';?>
                            <tr class="<?=$satirRenk?>">
                                <td><?=$data['id']?></td>
                                <td><?=DateFormat($data['giris_tarih'], 'd/m/Y H:i')?></td>
                                <td><?=DateFormat($data['cikis_tarih'], 'd/m/Y H:i')?></td>
                                <td><?=CalculateTimeDifference($data['giris_tarih'], $data['cikis_tarih'])?></td>
                                <td><?=$data['plaka']?></td>
                                <td><?=$data['firma']?></td>
                                <td><?=$data['ad_soyad']?></td>
                                <td><?=$data['arac_tur_text']?></td>
                                <td><?=$data['aciklama']?></td>
                                <td>
                                    <? if ($data['cikis_tarih']=='0000-00-00 00:00:00' && checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisAdd')) ) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitGetir(3, <?=$data['id']?>, 1)" class="kt-badge kt-badge--success kt-badge--inline"><i class="pr-1 fa fa-door-open"></i>  Çıkış Yap</span>
                                    <? } if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisEdit'))) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitGetir(2, <?=$data['id']?>, 1)" class="kt-badge kt-badge--brand kt-badge--inline"><i class="pr-1 fa fa-pencil"></i>  Düzenle</span>
                                    <? } if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisRemove'))) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitSil(<?=$data['id']?>)" class="kt-badge kt-badge--danger kt-badge--inline"><i class="pr-1 fa fa-trash"></i>  Sil</span>
                                    <? } ?>
                                </td>
                            </tr>
                        <? } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="kt-separator kt-separator--fit"></div>

        <div class="kt-separator kt-separator--fit"></div>

    <? } else if ($type=='xlsx' || $type=='print') {

        $setCreator = $CurrentUser['name'] . ' ' . $CurrentUser['surname'];
        $setCreatorInitial = $CurrentUser['initial'];
        $setLastModifiedBy = $CurrentUser['name'] . ' ' . $CurrentUser['surname'];
        $setTitle = 'dERM Report-Güvenlik Giriş Çıkış';
        $setSubject = 'dERM Report-Güvenlik Giriş Çıkış';
        $setDescription = 'dERM Report-Güvenlik Giriş Çıkış';
        $setKeywords = 'dERM Report-Güvenlik Giriş Çıkış';
        $setCategory = 'dERM Report-Güvenlik Giriş Çıkış';
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
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:O1');


        // Add header
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Giris Tar.')
            ->setCellValue('C1', 'Cikis Tar.')
            ->setCellValue('D1', 'Arac Turu')
            ->setCellValue('E1', 'Plaka')
            ->setCellValue('F1', 'Firma')
            ->setCellValue('G1', 'Ad Soyad')
            ->setCellValue('H1', 'Fis No')
            ->setCellValue('I1', 'KM')
            ->setCellValue('J1', 'Cop Saha')
            ->setCellValue('K1', 'Ocak')
            ->setCellValue('L1', 'Tarti1')
            ->setCellValue('M1', 'Tarti2')
            ->setCellValue('N1', 'Net')
            ->setCellValue('O1', 'Aciklama');
        $rowActive = 2;

        // Add Data
        $dataoncelik = '';
        foreach ($dataList as $data) {
            $spreadsheet->getActiveSheet()->setCellValue("A$rowActive", $data['id']);
            $spreadsheet->getActiveSheet()->setCellValue("B$rowActive", \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( date($data['giris_tarih']) ));
            $spreadsheet->getActiveSheet()->setCellValue("C$rowActive", \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( date($data['cikis_tarih']) ));
            $spreadsheet->getActiveSheet()->setCellValue("D$rowActive", $data['arac_tur_text']);
            $spreadsheet->getActiveSheet()->setCellValue("E$rowActive", $data['plaka']);
            $spreadsheet->getActiveSheet()->setCellValue("F$rowActive", $data['firma']);
            $spreadsheet->getActiveSheet()->setCellValue("G$rowActive", $data['ad_soyad']);
            $spreadsheet->getActiveSheet()->setCellValue("H$rowActive", $data['fis_no']);
            $spreadsheet->getActiveSheet()->setCellValue("I$rowActive", $data['km']);
            $spreadsheet->getActiveSheet()->setCellValue("J$rowActive", $data['cop_saha_text']);
            $spreadsheet->getActiveSheet()->setCellValue("K$rowActive", $data['ocak']);
            $spreadsheet->getActiveSheet()->setCellValue("L$rowActive", $data['tarti1']);
            $spreadsheet->getActiveSheet()->setCellValue("M$rowActive", $data['tarti2']);
            $spreadsheet->getActiveSheet()->setCellValue("N$rowActive", CalculateAbsDifference($data['tarti2'],$data['tarti1']));
            $spreadsheet->getActiveSheet()->setCellValue("O$rowActive", $data['aciklama']);
            $rowActive++;
        }

        // Calculate Rows
        $rowLast = $spreadsheet->getActiveSheet()->getHighestRow();

        // Set column widths
        foreach (range('B', 'O') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

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
        $spreadsheet->getActiveSheet()->getStyle('A1:O1')->applyFromArray($headerStyleArray);

        // Set column format
        $spreadsheet->getActiveSheet()->getStyle('B1:B' . $rowLast)->getNumberFormat()->setFormatCode('dd.mm.yyyy H:m');
        $spreadsheet->getActiveSheet()->getStyle('C1:C' . $rowLast)->getNumberFormat()->setFormatCode('dd.mm.yyyy H:m');


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






    }

}










