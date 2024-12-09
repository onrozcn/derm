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




if ($action == 'HamGirisKaydet') {
    HamGirisKaydet($_POST);
}

function HamGirisKaydet($post)
{
    global $CurrentFirm, $CurrentUser;

    $id = (isset($post['id']) && !empty($post['id']) && is_numeric($post['id'])) ? MysqlSecureText($post['id']) : 0;
    $tarih = (isset($post['tarih']) && !empty($post['tarih'])) ? JsSlashDateFix(MysqlSecureText($post['tarih'])) : '0000-00-00';
    $nakliye_id = (isset($post['nakliye_id']) && !empty($post['nakliye_id']) && is_numeric($post['nakliye_id'])) ? MysqlSecureText($post['nakliye_id']) : 0;
    $nakliye_plaka = (isset($post['nakliye_plaka']) && !empty($post['nakliye_plaka'])) ? MysqlSecureText($post['nakliye_plaka']) : '';
    $nakliye_sofor = (isset($post['nakliye_sofor']) && !empty($post['nakliye_sofor'])) ? MysqlSecureText($post['nakliye_sofor']) : '';
    $nakliye_fis_no = (isset($post['nakliye_fis_no']) && !empty($post['nakliye_fis_no'])) ? MysqlSecureText($post['nakliye_fis_no']) : '';
    $nakliye_sefer_no = (isset($post['nakliye_sefer_no']) && !empty($post['nakliye_sefer_no'])) ? MysqlSecureText($post['nakliye_sefer_no']) : '';
    $nakliye_tonaj = (isset($post['nakliye_tonaj']) && !empty($post['nakliye_tonaj']) && is_numeric($post['nakliye_tonaj'])) ? MysqlSecureText($post['nakliye_tonaj']) : 0;
    $nakliye_ocak_id = (isset($post['nakliye_ocak_id']) && !empty($post['nakliye_ocak_id']) && is_numeric($post['nakliye_ocak_id'])) ? MysqlSecureText($post['nakliye_ocak_id']) : 0;
    $nakliye_saha_id = (isset($post['nakliye_saha_id']) && !empty($post['nakliye_saha_id']) && is_numeric($post['nakliye_saha_id'])) ? MysqlSecureText($post['nakliye_saha_id']) : 0;

    $nakliye_up = false;
    $dataUserId = $CurrentUser['id'];
    $dataDatetime = date('Y-m-d H:i:s', time());


    if ( $tarih == '0000-00-00' || $nakliye_id == 0 || empty($nakliye_plaka) || empty($nakliye_sofor) || empty($nakliye_fis_no) || empty($nakliye_sefer_no) || empty($nakliye_tonaj) || $nakliye_ocak_id == 0 || $nakliye_saha_id == 0 ) {
        JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
    } else {
        if ($id <= 0) {
            if (AddToTable(
                'ham_giris_nakliye',
                array('sirket_id', 'tarih', 'nakliye_id', 'nakliye_plaka', 'nakliye_sofor', 'nakliye_fis_no', 'nakliye_sefer_no', 'nakliye_tonaj', 'nakliye_ocak_id', 'nakliye_saha_id', 'recordUserId', 'recordDateTime'),
                array($CurrentFirm['id'], $tarih, $nakliye_id, $nakliye_plaka, $nakliye_sofor, $nakliye_fis_no, $nakliye_sefer_no, $nakliye_tonaj, $nakliye_ocak_id, $nakliye_saha_id, $dataUserId, $dataDatetime),
                false, false
            )) {
                $id = GetMaxIdOfTable('ham_giris_nakliye');
                $nakliye_up = true;
            }
        } else {
            if (UpdateTable2('ham_giris_nakliye',
                array('sirket_id', 'tarih', 'nakliye_id', 'nakliye_plaka', 'nakliye_sofor', 'nakliye_fis_no', 'nakliye_sefer_no', 'nakliye_tonaj', 'nakliye_ocak_id', 'nakliye_saha_id', 'recordUserId', 'recordDateTime'),
                array($CurrentFirm['id'], $tarih, $nakliye_id, $nakliye_plaka, $nakliye_sofor, $nakliye_fis_no, $nakliye_sefer_no, $nakliye_tonaj, $nakliye_ocak_id, $nakliye_saha_id, $dataUserId . $dataDatetime),
                'id',
                $id
            )) {
                $nakliye_up = true;
            }
        }

        $errors = array();
        if ($nakliye_up && $id > 0) {
            $hgt_count = (isset($post['hgt_id'])) ? count($post['hgt_id']) : 0;

            // tas_tur_id ayni mi kontrolu
            if ( min($post['tas_tur_id']) === max($post['tas_tur_id']) && $post['tas_tur_id'][0] == 1) { // tum degerler bloksa
                $calc_tas_tonaj_check = 'blok';
                $calc_tas_rate = 0;
                for ($i = 0; $i < $hgt_count; $i++) {
                    $calc_tas_rate += CmToM3($post['tas_en'][$i], $post['tas_boy'][$i], $post['tas_yukseklik'][$i],'en');
                }
                $calc_tas_tonaj_rate  = '';
            } else if ( min($post['tas_tur_id']) === max($post['tas_tur_id']) && $post['tas_tur_id'][0] == 2) { // tum degeler molozsa
                $calc_tas_tonaj_check = 'moloz';
                $calc_tas_tonaj_value = round($nakliye_tonaj / $hgt_count, 2);
            } else {
                $calc_tas_tonaj_check = 'karma';
            }

            $post_ids = array();

            for ($i = 0; $i < $hgt_count; $i++) {
                $hgt_id = (isset($post['hgt_id'][$i]) && !empty($post['hgt_id'][$i]) && is_numeric($post['hgt_id'][$i])) ? MysqlSecureText($post['hgt_id'][$i]) : 0;
                $hgt_tas_tur_id = (isset($post['tas_tur_id'][$i]) && !empty($post['tas_tur_id'][$i]) && is_numeric($post['tas_tur_id'][$i])) ? MysqlSecureText($post['tas_tur_id'][$i]) : 0;
                $hgt_tas_ocak_id = (isset($post['tas_ocak_id'][$i]) && !empty($post['tas_ocak_id'][$i]) && is_numeric($post['tas_ocak_id'][$i])) ? MysqlSecureText($post['tas_ocak_id'][$i]) : 0;
                $hgt_tas_kalite_id = (isset($post['tas_kalite_id'][$i]) && !empty($post['tas_kalite_id'][$i]) && is_numeric($post['tas_kalite_id'][$i])) ? MysqlSecureText($post['tas_kalite_id'][$i]) : 0;
                if ($calc_tas_tonaj_check == 'blok') {
                    $hgt_tas_tonaj = $nakliye_tonaj / $calc_tas_rate * CmToM3($post['tas_en'][$i], $post['tas_boy'][$i], $post['tas_yukseklik'][$i], 'en');
                } else if ($calc_tas_tonaj_check == 'moloz') {
                    $hgt_tas_tonaj = $calc_tas_tonaj_value;
                } else if ($calc_tas_tonaj_check == 'karma') {
                    $hgt_tas_tonaj = (isset($post['tas_tonaj'][$i]) && !empty($post['tas_tonaj'][$i])) ? $post['tas_tonaj'][$i] : 0;
                }
                $hgt_tas_ocak_no = (isset($post['tas_ocak_no'][$i]) && !empty($post['tas_ocak_no'][$i])) ? $post['tas_ocak_no'][$i] : '';
                $hgt_tas_fabrika_no = (isset($post['tas_fabrika_no'][$i]) && !empty($post['tas_fabrika_no'][$i])) ? $post['tas_fabrika_no'][$i] : '';
                $hgt_tas_en = (isset($post['tas_en'][$i]) && !empty($post['tas_en'][$i])) ? $post['tas_en'][$i] : '';
                $hgt_tas_boy = (isset($post['tas_boy'][$i]) && !empty($post['tas_boy'][$i])) ? $post['tas_boy'][$i] : '';
                $hgt_tas_yukseklik = (isset($post['tas_yukseklik'][$i]) && !empty($post['tas_yukseklik'][$i])) ? $post['tas_yukseklik'][$i] : '';
                $hgt_tas_irsaliye_no = (isset($post['tas_irsaliye_no'][$i]) && !empty($post['tas_irsaliye_no'][$i])) ? $post['tas_irsaliye_no'][$i] : '';


                if ($hgt_id <= 0) {
                    if (!AddToTable(
                        'ham_giris_tas',
                        array('sirket_id', 'hg_nakliye_id', 'tas_tur_id', 'tas_ocak_id', 'tas_kalite_id', 'tas_tonaj', 'tas_ocak_no', 'tas_fabrika_no', 'en', 'boy', 'yukseklik', 'tas_irsaliye_no'),
                        array($CurrentFirm['id'], $id, $hgt_tas_tur_id, $hgt_tas_ocak_id, $hgt_tas_kalite_id, $hgt_tas_tonaj, $hgt_tas_ocak_no, $hgt_tas_fabrika_no, $hgt_tas_en, $hgt_tas_boy, $hgt_tas_yukseklik, $hgt_tas_irsaliye_no),
                        false, false
                    )
                    ) {
                        $errors[] = '1';
                    } else {
                        $hgt_id = GetMaxIdOfTable('ham_giris_tas');
                        $post_ids[] = $hgt_id;
                    }
                } else {
                    $post_ids[] = $hgt_id;
                    if (!UpdateTable2('ham_giris_tas',
                        array('tas_tur_id', 'tas_ocak_id', 'tas_kalite_id', 'tas_tonaj', 'tas_ocak_no', 'tas_fabrika_no', 'en', 'boy', 'yukseklik', 'tas_irsaliye_no'),
                        array($hgt_tas_tur_id, $hgt_tas_ocak_id, $hgt_tas_kalite_id, $hgt_tas_tonaj, $hgt_tas_ocak_no, $hgt_tas_fabrika_no, $hgt_tas_en, $hgt_tas_boy, $hgt_tas_yukseklik, $hgt_tas_irsaliye_no),
                        'id',
                        $hgt_id
                    )
                    ) {
                        $errors[] = '1';
                    }
                }

            }

            $hg_tas = GetListDataFromTableWithSingleWhere('ham_giris_tas', 'id', 'id', 'hg_nakliye_id=' . $id);
            foreach ($hg_tas as $p) {
                if (!in_array($p['id'], $post_ids)) {
                    DeleteById('ham_giris_tas', 'id', $p['id'], false);
                }
            }

            $message = (count($errors) > 0) ? 'Nakliye ve tas girisi yapildi, ancak bazi tas girislerinde hatalar var. Kontrol ediniz.' : 'Nakliye ve tas girisi yapildi.';
            JsonResult('ok', $message, $id);

        } else {
            JsonResult('fail', 'An error occurred while processing data.', 0);
        }
    }
}


if ($action == 'HamGirisTabloGetir') {
    HamGirisTabloGetir(
        isset($_POST['type']) ? MysqlSecureText($_POST['type']) : 'screen',
        isset($_POST['page']) ? MysqlSecureText($_POST['page']) : 1
    );
}

function HamGirisTabloGetir($type, $page)
{

    global $CurrentFirm, $CurrentUser;

    $tableItemCount = 200;

    $dataWhereText  = 'hgn.sirket_id=' . $CurrentFirm['id'];
    $dataFromText   = 'ham_giris_nakliye hgn';
    $dataFromText  .= ' LEFT JOIN param_ham_nakliyeciler param_nakliyeciler ON (param_nakliyeciler.id=hgn.nakliye_id)';
    $dataFromText  .= ' LEFT JOIN param_ham_ocaklar param_ocaklar ON param_ocaklar.id = hgn.nakliye_ocak_id';
    $dataFromText  .= ' LEFT JOIN param_ham_sahalar param_sahalar ON param_sahalar.id = hgn.nakliye_saha_id';
    $dataSelectText  = 'hgn.*, param_nakliyeciler.tag as "nakliye_tag", param_ocaklar.tag as "ocak_tag", param_sahalar.tag as "saha_tag"';
    $dataOrderText  = 'hgn.id DESC';
    $ham_giris_nakliye = GetListDataFromTableWithSingleWhereAndLimit($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, $page, $tableItemCount, false);

    if ($type == 'screen') { ?>
    <div class="table-responsive">
        <table class="table table-bordered derm-table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>Tarih</th>
                <th>Nakliyeci</th>
                <th>Plaka</th>
                <th>Sofor</th>
                <th>Tonaj</th>
                <th>Ocak</th>
                <th>Saha</th>
                <th>Tur</th>
                <th>Ocak</th>
                <th>Kalite</th>
                <th>Tonaj</th>
                <th>Fiyat</th>
                <th>Ocak No</th>
                <th>Fabrika No</th>
                <th>En</th>
                <th>Boy</th>
                <th>Yukseklik</th>
                <th>M3</th>
                <th>İrs. No</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($ham_giris_nakliye as $hgn) {
                $hgtFromText  = 'ham_giris_tas hgt';
                $hgtFromText .= ' LEFT JOIN param_ham_turler param_turler ON (hgt.tas_tur_id=param_turler.id)';
                $hgtFromText .= ' LEFT JOIN param_ham_ocaklar param_ocaklar ON (hgt.tas_ocak_id=param_ocaklar.id)';
                $hgtFromText .= ' LEFT JOIN param_ham_kaliteler param_kaliteler ON (hgt.tas_kalite_id=param_kaliteler.id)';
                $hgtSelectText  = 'hgt.*';
                $hgtSelectText .= ', param_turler.tag as "tur_tag"';
                $hgtSelectText .= ', param_ocaklar.tag as "ocak_tag"';
                $hgtSelectText .= ', param_kaliteler.isim as "kalite_tag"';
                $ham_giris_tas = GetListDataFromTableWithSingleWhere($hgtFromText, $hgtSelectText, 'hgt.id', 'hgt.hg_nakliye_id=' . $hgn['id'], false);
                $rowspan = count($ham_giris_tas) > 0 ? count($ham_giris_tas) : 1;

            ?>
            <tr>
                <td rowspan="<?=$rowspan?>"><?=DateFormat($hgn['tarih'], 'd/m/Y')?></td>
                <td rowspan="<?=$rowspan?>"><?=$hgn['nakliye_tag']?></td>
                <td rowspan="<?=$rowspan?>"><?=$hgn['nakliye_plaka']?></td>
                <td rowspan="<?=$rowspan?>"><?=$hgn['nakliye_sofor']?></td>
                <td rowspan="<?=$rowspan?>" align="right"><?=FloatFormat($hgn['nakliye_tonaj'], 0)?></td>
                <td rowspan="<?=$rowspan?>"><?=$hgn['ocak_tag']?></td>
                <td rowspan="<?=$rowspan?>"><?=$hgn['saha_tag']?></td>
                <? if (count($ham_giris_tas) > 0) { ?>
                <td><?=$ham_giris_tas[0]['tur_tag']?></td>
                <td><?=$ham_giris_tas[0]['ocak_tag']?></td>
                <td><?=$ham_giris_tas[0]['kalite_tag']?></td>
                <td align="right"><?=FloatFormat($ham_giris_tas[0]['tas_tonaj'], 0)?></td>
                <td align="right"><?=$ham_giris_tas[0]['tas_fiyat']?></td>
                <td align="right"><?=$ham_giris_tas[0]['tas_ocak_no']?></td>
                <td align="right"><?=$ham_giris_tas[0]['tas_fabrika_no']?></td>
                <td align="right"><?=$ham_giris_tas[0]['en']?></td>
                <td align="right"><?=$ham_giris_tas[0]['boy']?></td>
                <td align="right"><?=$ham_giris_tas[0]['yukseklik']?></td>
                <td align="right"><?=CmToM3($ham_giris_tas[0]['en'], $ham_giris_tas[0]['boy'], $ham_giris_tas[0]['yukseklik'])?></td>
                <td align="right"><?=$ham_giris_tas[0]['tas_irsaliye_no']?></td>
                <td rowspan="<?=$rowspan?>">
                    <span onclick="HammaddeGirisGetir(<?=$hgn['id']?>)" class="kt-badge kt-badge--brand kt-badge--inline"><i class="pr-1 fa fa-pencil"></i> Düzenle</span>
                    <span onclick="HammaddeGirisSil(<?=$hgn['id']?>)" class="kt-badge kt-badge--danger kt-badge--inline"><i class="pr-1 fa fa-trash"></i> Sil</span>
                </td>
                <? } else { ?>
                <td colspan="12"></td>
                <? } if (count($ham_giris_tas) > 1) {
                $sy = 1;
                foreach ($ham_giris_tas as $hgt) {
                    if ($sy == 1) {
                        $sy++;
                        continue; } ?>
                        <tr>
                            <td><?=$hgt['tur_tag']?></td>
                            <td><?=$hgt['ocak_tag']?></td>
                            <td><?=$hgt['kalite_tag']?></td>
                            <td align="right"><?=FloatFormat($hgt['tas_tonaj'], 0)?></td>
                            <td align="right"><?=$hgt['tas_fiyat']?></td>
                            <td align="right"><?=$hgt['tas_ocak_no']?></td>
                            <td align="right"><?=$hgt['tas_fabrika_no']?></td>
                            <td align="right"><?=$hgt['en']?></td>
                            <td align="right"><?=$hgt['boy']?></td>
                            <td align="right"><?=$hgt['yukseklik']?></td>
                            <td align="right"><?=CmToM3($hgt['en'], $hgt['boy'], $hgt['yukseklik'])?></td>
                            <td align="right"><?=$hgt['tas_irsaliye_no']?></td>
                        </tr>
                        <?php $sy++;
                    }
                } ?>
            </tr>
            <? } ?>
            </tbody>
        </table>
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
        isset($_POST['aciklama']) ? MysqlSecureText($_POST['aciklama']) : ''
    );
}

function GuvenlikGirisCikisKaydet($id, $giris_tarih, $cikis_tarih, $arac_tur, $plaka, $firma, $ad_soyad, $fis_no, $km, $cop_saha, $ocak, $tarti1, $tarti2, $aciklama)
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
        if (!empty($aciklama)) { $telegram_text .= "Açıklama: $aciklama"; }

        $users = UserListByPermission('TELEGRAMgvnAracGiriscikis', true);
        $sendTelegram = '';
        foreach ($users as $user) {
            $sendTelegram .= TelegramSendMessage($setting['telegram_token'], $user['telegram_chatid'], 'sendMessage', $telegram_text);
        }

//        $sendTelegram = array(
//                TelegramSendMessage($setting['telegram_token'], '1640474785', 'sendMessage', $telegram_text), //onur
//                TelegramSendMessage($setting['telegram_token'], '2006282778', 'sendMessage', $telegram_text), // ferhat
//        );
        /* ----- TELEGRAM ----- */

        if ($id > 0) {
            if (UpdateTable(
                'gvn_aracgiriscikis',
                array('sirket_id', 'giris_tarih', 'cikis_tarih', 'arac_tur', 'plaka', 'firma', 'ad_soyad', 'fis_no', 'km', 'cop_saha', 'ocak', 'tarti1', 'tarti2', 'aciklama', 'updateUserId', 'updateDateTime'),
                array($CurrentFirm['id'], $giris_tarih, $cikis_tarih, $arac_tur, $plaka, $firma, $ad_soyad, $fis_no, $km, $cop_saha, $ocak, $tarti1, $tarti2, $aciklama, $dataUserId, $dataDatetime),
                'id', $id)) {
                JsonResult('ok', 'Kayıt Düzenlendi' , $id);
                $sendTelegram;
            }
            else {
                JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
            }
        }
        else {
            if (AddToTable(
                'gvn_aracgiriscikis',
                array('sirket_id', 'giris_tarih', 'cikis_tarih', 'arac_tur', 'plaka', 'firma', 'ad_soyad', 'fis_no', 'km', 'cop_saha', 'ocak', 'tarti1', 'tarti2', 'aciklama', 'recordUserId', 'recordDateTime'),
                array($CurrentFirm['id'], $giris_tarih, $cikis_tarih, $arac_tur, $plaka, $firma, $ad_soyad, $fis_no, $km, $cop_saha, $ocak, $tarti1, $tarti2, $aciklama, $dataUserId, $dataDatetime),
                false, false)) {
                JsonResult('ok', 'Kayıt eklendi', GetLastIdData('gvn_aracgiriscikis'));
                $sendTelegram;
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

    $array = array('result' => 'fail', 'id' => $id, 'giris_tarih' => '', 'cikis_tarih' => '', 'arac_tur' => '', 'plaka' => '', 'firma' => '', 'ad_soyad' => '', 'fis_no' => '', 'km' => '', 'cop_saha' => '', 'ocak' => '', 'tarti1' => '', 'tarti2' => '', 'aciklama' => '');

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
            $array['aciklama'] = $data['aciklama'];

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


if ($action == 'TasOcakIdToTur') {
    TasOcakIdToTur(
        isset($_GET['ocak_id']) ? MysqlSecureText($_GET['ocak_id']) : 0
    );
}

function TasOcakIdToTur($ocak_id)
{
    $get_data = GetListDataFromTableWithSingleWhere('param_ham_kaliteler phkaliteler LEFT JOIN param_ham_turler phturler ON (phturler.id=phkaliteler.turler_id)', '*', 'phkaliteler.id','phkaliteler.ocaklar_id=' . $ocak_id, false);
    $data = unique_multidim_array($get_data, 'id');
    ?>

    <option value="0">Seçiniz</option>
    <? foreach ($data as $d) { ?>
    <option value="<?=$d['id']?>"><?=$d['tag']?></option>
<? }
}


if ($action == 'TasTurIdToKalite') {
    TasTurIdToKalite(
        isset($_GET['tur_id']) ? MysqlSecureText($_GET['tur_id']) : 0,
        isset($_GET['ocak_id']) ? MysqlSecureText($_GET['ocak_id']) : 0
    );
}

function TasTurIdToKalite($tur_id, $ocak_id)
{
    $get_data = GetListDataFromTableWithSingleWhere('param_ham_kaliteler phkaliteler LEFT JOIN param_ham_ocaklar phocaklar ON (phocaklar.id=phkaliteler.ocaklar_id)', '*, phkaliteler.id as "tas_id"', 'phkaliteler.id','phkaliteler.turler_id=' . $tur_id . ' AND phkaliteler.ocaklar_id=' . $ocak_id, false);
    $data = unique_multidim_array($get_data, 'tas_id');
    ?>

    <option value="0">Seçiniz</option>
    <? foreach ($data as $d) { ?>
    <option value="<?=$d['tas_id']?>"><?=$d['isim']?></option>
<? }
}


if ($action == 'LastSeferNoBul') {
    LastSeferNoBul();
}

function LastSeferNoBul()
{
    global $CurrentFirm;

    $data = GetMaxIdDataOfWhere('ham_giris_nakliye', 'sirket_id='. $CurrentFirm['id']);

    $value = array();

    $value['nakliye_sefer_no'] = $data['nakliye_sefer_no'] + 1;


    echo json_encode($value);

}












