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

    $dataWhereTextCop   = 'agc.sirket_id=' . $CurrentFirm['id'] . ' AND agc.arac_tur=3';
    $dataWhereTextCop  .= ' AND agc.cikis_tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
    $dataFromTextCop    = 'gvn_aracgiriscikis agc ';
    $dataFromTextCop   .= '';
    $dataSelectTextCop  = 'agc.*';
    $dataSelectTextCop .= ' ,CASE agc.cop_saha WHEN 1 then "Kaklık" WHEN 2 then "Kocabaş" WHEN 3 then "Diğer" end as cop_saha_text';
    $dataOrderTextCop   = 'id DESC';
    $dataListCop = GetListDataFromTableWithSingleWhereAndLimit($dataFromTextCop, $dataSelectTextCop, $dataOrderTextCop, $dataWhereTextCop, $page, $tableItemCount, false);

    $dataWhereTextHammadde   = 'agc.sirket_id=' . $CurrentFirm['id'] . ' AND agc.arac_tur=4';
    $dataWhereTextHammadde  .= ' AND agc.giris_tarih BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
    $dataFromTextHammadde    = 'gvn_aracgiriscikis agc ';
    $dataFromTextHammadde   .= '';
    $dataSelectTextHammadde  = 'agc.*';
    $dataSelectTextHammadde .= '';
    $dataOrderTextHammadde   = 'id DESC';
    $dataListHammadde = GetListDataFromTableWithSingleWhereAndLimit($dataFromTextHammadde, $dataSelectTextHammadde, $dataOrderTextHammadde, $dataWhereTextHammadde, $page, $tableItemCount, false);


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



        $perColAciklamaGiris = '10%';          // 11
        $perColAciklamaCikis = '10%';          // 11
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
                            <th width="<?=$perColAciklamaGiris?>">Giriş Not</th>
                            <th width="<?=$perColAciklamaCikis?>">Çıkış Not</th>
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
                                <td><?=$data['aciklama_cikis']?></td>
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
        <div class="row">
            <div class="col-12">
                <h3 class="text-right pb-2">Çöp Kamyonu Hareketleri / <?=count($dataListCop)?></h3>
                <div class="table-responsive">
                    <table class="table table-bordered derm-table" style="font-size: 13px;">
                        <thead>
                        <tr>
                            <th width="<?=$perColId?>">#</th>
                            <th width="<?=$perColGiris?>">Çıkış Tarih</th>
                            <th width="<?=$perColGiris?>">Giriş Tarih</th>
                            <th width="<?=$perColSure?>">Süre</th>
                            <th width="<?=$perColPlaka?>">Plaka</th>
                            <th width="<?=$perColFirma?>">Firma</th>
                            <th width="<?=$perColAdSoyad?>">Ad Soyad</th>
                            <th width="<?=$perColFisNo?>">Çöp Fiş No</th>
                            <th width="<?=$perColKm?>">KM</th>
                            <th width="<?=$perColCopSaha?>">Saha</th>
                            <th width="<?=$perColAciklamaGiris?>">Giriş Not</th>
                            <th width="<?=$perColAciklamaCikis?>">Çıkış Not</th>
                            <th width="<?=$perColIslem?>">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($dataListCop as $data) { $data['giris_tarih']=='0000-00-00 00:00:00'?$satirRenk=' bg-warning':$satirRenk='';?>
                            <tr class="<?=$satirRenk?>">
                                <td><?=$data['id']?></td>
                                <td><?=DateFormat($data['cikis_tarih'], 'd/m/Y H:i')?></td>
                                <td><?=DateFormat($data['giris_tarih'], 'd/m/Y H:i')?></td>
                                <td><?=CalculateTimeDifference($data['giris_tarih'], $data['cikis_tarih'])?></td>
                                <td><?=$data['plaka']?></td>
                                <td><?=$data['firma']?></td>
                                <td><?=$data['ad_soyad']?></td>
                                <td><?=$data['fis_no']?></td>
                                <td><?=FloatFormat($data['km'], 0)?></td>
                                <td><?=$data['cop_saha_text']?></td>
                                <td><?=$data['aciklama']?></td>
                                <td><?=$data['aciklama_cikis']?></td>
                                <td>
                                    <? if ($data['giris_tarih']=='0000-00-00 00:00:00' && checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisAdd')) ) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitGetir(3, <?=$data['id']?>, 3)" class="kt-badge kt-badge--success kt-badge--inline"><i class="pr-1 fa fa-door-open"></i>  Giriş Yap</span>
                                    <? } if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisEdit'))) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitGetir(2, <?=$data['id']?>, 3)" class="kt-badge kt-badge--brand kt-badge--inline"><i class="pr-1 fa fa-pencil"></i>  Düzenle</span>
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
        <div class="row">
            <div class="col-12">
                <h3 class="text-right pb-2">Hammadde Hareketleri / <?=count($dataListHammadde)?></h3>
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
                            <th>Ocak</th>
                            <th>1. Tartı</th>
                            <th>2. Tartı</th>
                            <th>Net Tartı</th>
                            <th width="<?=$perColAciklamaGiris?>">Giriş Not</th>
                            <th width="<?=$perColAciklamaCikis?>">Çıkış Not</th>
                            <th width="<?=$perColIslem?>">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($dataListHammadde as $data) { $data['cikis_tarih']=='0000-00-00 00:00:00'?$satirRenk=' bg-warning':$satirRenk='';?>
                            <tr class="<?=$satirRenk?>">
                                <td><?=$data['id']?></td>
                                <td><?=DateFormat($data['giris_tarih'], 'd/m/Y H:i')?></td>
                                <td><?=DateFormat($data['cikis_tarih'], 'd/m/Y H:i')?></td>
                                <td><?=CalculateTimeDifference($data['giris_tarih'], $data['cikis_tarih'])?></td>
                                <td><?=$data['plaka']?></td>
                                <td><?=$data['firma']?></td>
                                <td><?=$data['ad_soyad']?></td>
                                <td><?=$data['ocak']?></td>
                                <td><?=FloatFormat($data['tarti1'], 0)?></td>
                                <td><?=FloatFormat($data['tarti2'], 0)?></td>
                                <td><?=FloatFormat(CalculateAbsDifference($data['tarti2'], $data['tarti1']), 0)?></td>
                                <td><?=$data['aciklama']?></td>
                                <td><?=$data['aciklama_cikis']?></td>
                                <td>
                                    <? if ($data['cikis_tarih']=='0000-00-00 00:00:00' && checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisAdd')) ) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitGetir(3, <?=$data['id']?>, 4)" class="kt-badge kt-badge--success kt-badge--inline"><i class="pr-1 fa fa-door-open"></i>  Çıkış Yap</span>
                                    <? } if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisEdit'))) { ?>
                                    <span onclick="GuvenlikGirisCikisKayitGetir(2, <?=$data['id']?>, 4)" class="kt-badge kt-badge--brand kt-badge--inline"><i class="pr-1 fa fa-pencil"></i>  Düzenle</span>
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





if ($action == 'GuvenlikGirisCikisKaydet') {
    GuvenlikGirisCikisKaydet(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
        isset($_POST['giris_tarih']) ? Html5DateTimeLocalDecode(MysqlSecureText($_POST['giris_tarih'])) : '0000-00-00 00:00:00',
        isset($_POST['cikis_tarih']) ? Html5DateTimeLocalDecode(MysqlSecureText($_POST['cikis_tarih'])) : '0000-00-00 00:00:00',
        isset($_POST['arac_tur']) ? MysqlSecureText($_POST['arac_tur']) : '',
        isset($_POST['plaka']) ? MysqlSecureText($_POST['plaka']) : '',
        isset($_POST['firma']) ? MysqlSecureText($_POST['firma']) : '',
        isset($_POST['ad_soyad']) ? MysqlSecureText($_POST['ad_soyad']) : '',
        isset($_POST['fis_no']) ? MysqlSecureText($_POST['fis_no']) : '',
        isset($_POST['km']) ? MysqlSecureText($_POST['km']) : '',
        isset($_POST['cop_saha']) ? MysqlSecureText($_POST['cop_saha']) : '',
        isset($_POST['ocak']) ? MysqlSecureText($_POST['ocak']) : '',
        isset($_POST['tarti1']) ? MysqlSecureText($_POST['tarti1']) : '',
        isset($_POST['tarti2']) ? MysqlSecureText($_POST['tarti2']) : '',
        isset($_POST['aciklamagiris']) ? MysqlSecureText($_POST['aciklamagiris']) : '',
        isset($_POST['aciklamacikis']) ? MysqlSecureText($_POST['aciklamacikis']) : ''
    );
}

function GuvenlikGirisCikisKaydet($id, $giris_tarih, $cikis_tarih, $arac_tur, $plaka, $firma, $ad_soyad, $fis_no, $km, $cop_saha, $ocak, $tarti1, $tarti2, $aciklamagiris, $aciklamacikis)
{
    global $setting, $CurrentUser, $CurrentFirm;

    if (empty($giris_tarih)) {
        $telegram_statu_icon = "\xE2\xAC\x86"; // up icon
    } else if (empty($cikis_tarih)) {
        $telegram_statu_icon = "\xE2\xAC\x87"; // down icon
    } else if (!empty($giris_tarih) && !empty($cikis_tarih)) {
        $telegram_statu_icon = "\xE2\x9C\x85"; //check icon
    }

    if ($arac_tur == 1) {
        $arac_tur_text = 'Misafir Araç';
        $telegram_arac_icon = "\xF0\x9F\x9A\x96";
    } else if ($arac_tur == 2) {
        $arac_tur_text = 'Şirket Aracı';
        $telegram_arac_icon = "\xF0\x9F\x9A\x98";
    } else if ($arac_tur == 3) {
        $arac_tur_text = 'Çöp Kamyonu';
        $telegram_arac_icon = "\xF0\x9F\x9A\x9A";
    } else if ($arac_tur == 4) {
        $arac_tur_text = 'Hammade Kamyonu';
        $telegram_arac_icon = "\xF0\x9F\x9A\x9B";
    }

    if ($cop_saha == 1) {
        $cop_saha_text = 'Kaklık';
    } else if ($cop_saha == 2) {
        $cop_saha_text = 'Kocabaş';
    } else if ($cop_saha == 3) {
        $cop_saha_text = 'Diğer';
    }

    if ($arac_tur == 0 ) {
        JsonResult('empty', '11Lütfen zorunla alanları doldurun', $id);
    } else if (($arac_tur == 1 || $arac_tur == 2) && (empty($arac_tur) || empty($plaka) || empty($firma) || empty($ad_soyad))) {
        JsonResult('empty', '22Lütfen zorunla alanları doldurun', $id);
    } else if (($arac_tur == 3) && (empty($arac_tur) || empty($plaka) || empty($firma) || empty($ad_soyad) || empty($fis_no) || empty($cop_saha))) {
        JsonResult('empty', '33Lütfen zorunla alanları doldurun', $id);
    } else if (($arac_tur == 4) && (empty($arac_tur) || empty($plaka) || empty($firma) || empty($ad_soyad) || empty($ocak) || empty($tarti1) || empty($tarti2))) {
        JsonResult('empty', '44Lütfen zorunla alanları doldurun', $id);
    }  else {
        $dataUserId = $CurrentUser['id'];
        $dataDatetime = date('Y-m-d H:i:s', time());

        /* ----- TELEGRAM ----- */
        $telegram_text  = "dERM Bilgilendirme - " . $CurrentFirm['tag'] . "\n" ;
        $telegram_text .= "$telegram_arac_icon $telegram_statu_icon Araç Giriş Çıkış Sistemi  \n";
        $telegram_text .= "Tür: $arac_tur_text \n" ;

        if (isset($giris_tarih) && !empty($giris_tarih) && Html5DateTimeLocalDecode($giris_tarih) != '0000-00-00 00:00:00') {
            $telegram_text .= "Giriş: " . DateFormat($giris_tarih, 'd/m/Y H:i') . "\n";
        }
        if (isset($cikis_tarih) && !empty($cikis_tarih) && Html5DateTimeLocalDecode($cikis_tarih) != '0000-00-00 00:00:00') {
            $telegram_text .= "Çıkış: " . DateFormat($cikis_tarih, 'd/m/Y H:i') . "\n";
        }
        if ( (!empty($giris_tarih) && !empty($cikis_tarih)) && (Html5DateTimeLocalDecode($giris_tarih) != '0000-00-00 00:00:00' && Html5DateTimeLocalDecode($cikis_tarih) != '0000-00-00 00:00:00') ) {
            $telegram_text .= "Süre: " . CalculateTimeDifference($giris_tarih, $cikis_tarih) . "\n";
        }

        if ( isset($fis_no) && !empty($fis_no) ) {
            $telegram_text .= "Fiş: $fis_no \n";
        }
        if ( isset($km) && !empty($km) ) {
            $telegram_text .= "KM: " . FloatFormat($km, 0) . "\n";
        }
        if ( isset($cop_saha_text) && !empty($cop_saha_text) ) {
            $telegram_text .= "Saha: " . $cop_saha_text . "\n";
        }

        if ( isset($ocak) && !empty($ocak) ) {
            $telegram_text .= "Ocak: $ocak \n";
        }
        if ( isset($tarti1) && !empty($tarti1) ) {
            $telegram_text .= "Tartı1: " . FloatFormat($tarti1, 0) . "\n";
        }
        if ( isset($tarti2) && !empty($tarti2) ) {
            $telegram_text .= "Tartı2: " . FloatFormat($tarti2, 0) . "\n";
        }
        if ( isset($tarti1) && !empty($tarti1) && isset($tarti2) && !empty($tarti2) ) {
            $telegram_text .= "Net: " . FloatFormat(CalculateAbsDifference($tarti1, $tarti2), 0) . "\n";
        }

        $telegram_text .= "Plaka: $plaka \n";
        $telegram_text .= "Firma: $firma \n";
        $telegram_text .= "İsim: $ad_soyad \n";
        if (!empty($aciklamagiris)) { $telegram_text .= "Giriş Not: $aciklamagiris" . "\n"; }
        if (!empty($aciklamacikis)) { $telegram_text .= "Çıkış Not: $aciklamacikis"; }

        if ( $setting['telegram_send_notification'] == true ) {
            $users = UserListByPermission('TELEGRAMgvnAracGiriscikis', true);
            foreach ($users as $user) {
                TelegramSendMessage($setting['telegram_token'], $user['telegram_chatid'], 'sendMessage', $telegram_text);
            }
        }

//        $sendTelegram = array(
//                TelegramSendMessage($setting['telegram_token'], '1640474785', 'sendMessage', $telegram_text), //onur
//                TelegramSendMessage($setting['telegram_token'], '2006282778', 'sendMessage', $telegram_text), // ferhat
//        );
        /* ----- TELEGRAM ----- */

        if ($id > 0) {
            if (UpdateTable(
                'gvn_aracgiriscikis',
                array('sirket_id', 'giris_tarih', 'cikis_tarih', 'arac_tur', 'plaka', 'firma', 'ad_soyad', 'fis_no', 'km', 'cop_saha', 'ocak', 'tarti1', 'tarti2', 'aciklama', 'aciklama_cikis', 'updateUserId', 'updateDateTime'),
                array($CurrentFirm['id'], $giris_tarih, $cikis_tarih, $arac_tur, $plaka, $firma, $ad_soyad, $fis_no, $km, $cop_saha, $ocak, $tarti1, $tarti2, $aciklamagiris, $aciklamacikis, $dataUserId, $dataDatetime),
                'id', $id)) {
                JsonResult('ok', 'Kayıt Düzenlendi', $id);
            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
            }
        }
        else {
            if (AddToTable(
                'gvn_aracgiriscikis',
                array('sirket_id', 'giris_tarih', 'cikis_tarih', 'arac_tur', 'plaka', 'firma', 'ad_soyad', 'fis_no', 'km', 'cop_saha', 'ocak', 'tarti1', 'tarti2', 'aciklama', 'aciklama_cikis', 'recordUserId', 'recordDateTime'),
                array($CurrentFirm['id'], $giris_tarih, $cikis_tarih, $arac_tur, $plaka, $firma, $ad_soyad, $fis_no, $km, $cop_saha, $ocak, $tarti1, $tarti2, $aciklamagiris, $aciklamacikis, $dataUserId, $dataDatetime),
                false, false)) {
                JsonResult('ok', 'Kayıt eklendi', GetLastIdData('gvn_aracgiriscikis'));
            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
            }
        }
    }
}


if ($action == 'GuvenlikGirisCikisKayitGetir') {
    GuvenlikGirisCikisKayitGetir(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function GuvenlikGirisCikisKayitGetir($id)
{
    global $CurrentFirm;

    $array = array('result' => 'fail', 'id' => $id, 'giris_tarih' => '', 'cikis_tarih' => '', 'arac_tur' => '', 'plaka' => '', 'firma' => '', 'ad_soyad' => '', 'fis_no' => '', 'km' => '', 'cop_saha' => '', 'ocak' => '', 'tarti1' => '', 'tarti2' => '', 'aciklamagiris' => '', 'aciklamacikis' => '');

    if (empty($id)) {
        $array['result'] = 'empty';
    }
    else {
        $data = GetSingleDataFromTableWithSingleWhere('gvn_aracgiriscikis', 'id=' . $id . ' AND sirket_id=' . $CurrentFirm['id']);
        if (empty($data)) {
            $array['result'] = 'fail';
        }
        else {
            $array['result'] = 'ok';
            if ($data['giris_tarih']=='0000-00-00 00:00:00') {
                $array['giris_tarih'] = NULL;
            } else {
                $array['giris_tarih'] = Html5DateTimeLocalEncode($data['giris_tarih']);
            }
            if ($data['cikis_tarih']=='0000-00-00 00:00:00') {
                $array['cikis_tarih'] = NULL;
            } else {
                $array['cikis_tarih'] = Html5DateTimeLocalEncode($data['cikis_tarih']);
            }
            $array['arac_tur'] = $data['arac_tur'];
            $array['plaka'] = $data['plaka'];
            $array['firma'] = $data['firma'];
            $array['ad_soyad'] = $data['ad_soyad'];
            $array['fis_no'] = $data['fis_no'];
            $array['km'] = $data['km'];
            $array['cop_saha'] = $data['cop_saha'];
            $array['ocak'] = $data['ocak'];
            $array['tarti1'] = $data['tarti1'];
            $array['tarti2'] = $data['tarti2'];
            $array['aciklamagiris'] = $data['aciklama'];
            $array['aciklamacikis'] = $data['aciklama_cikis'];

        }
    }

    echo json_encode($array);
}


if ($action == 'GuvenlikGirisCikisKayitSil') {
    GuvenlikGirisCikisKayitSil(
        isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0
    );
}

function GuvenlikGirisCikisKayitSil($id)
{
    if (empty($id)) {
        JsonResult('empty', 'Kayit secilmemis', 0);
    }
    else {
        if (DeleteById('gvn_aracgiriscikis', 'id', $id, false)) {
            JsonResult('ok', 'Silindi', 0);
        }
        else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', 0);
        }
    }
}









