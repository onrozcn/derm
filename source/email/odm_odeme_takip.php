<?php
require_once('/../../source/settings.php');

// TRUE  = komut satiri modu << C:\xampp\php\php.exe C:\xampp\htdocs\stockgenius\source\emails\shipreport.php date=2018-03-05 >> date varsayilan bugun
// FALSE = webserver modu << http://localhost/stockgenius/source/emails/shipreport.php?date=2018-03-06 >> date varsayilan bugun
$commandMode = false;


// TRUE  = email gonderme
// FALSE = email gonder
$demoMode    = true;


if ($commandMode==false) {
	mailOdemeTakip(
        isset($_GET['sirket']) ? MysqlSecureText($_GET['sirket']) : 1,
	    isset($_GET['date']) ? MysqlSecureText($_GET['date']) : date('Y-m-d')
    );
}
else {
	// /path_to_script/cronjob.php username=test password=test code=1234 
	// var_dump($argv);
	/*
	array(4) {
	  [0]=>
	  string(27) "/path_to_script/***.php"
	  [1]=>
	  string(13) "date=test"
	  [2]=>
	  string(13) "password=test"
	  [3]=>
	  string(9) "code=1234"
	}
	*/
	if ($argc > 1) {
		parse_str($argv[1], $params);
		//echo $params['date']; 
		$date = $params['date'];
        mailOdemeTakip($date);
	}
	else {
        mailOdemeTakip(date('Y-m-d'));
	}
}


function mailOdemeTakip($sirket, $date)
{
	global $setting, $demoMode;

    $sirket = GetSingleDataFromTable('param_ana_sirketler', $sirket);

    $borcluFirmList = GetListDataFromTableWithSingleWhere('param_odm_borclusirketler', 'id, tag, unvan', 'id', 'sirket_id=' . $sirket['id'], false);




    $mailContent = '';
    $mailContent .= '<!-- begin textarea with table -->
    <table width="100%" bgcolor="#f7f7f7" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="left-image">
        <tbody>
        <tr>
            <td height="11" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                    <tbody>
                    <tr>
                        <td width="100%">
                            <table bgcolor="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                <tbody>
                                <tr>
                                    <td height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="550" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table width="550" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #2d2a26; text-align:left; line-height: 16px;" class="padding-top-right15">
                                                                Ödeme Takip Detay
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100%" height="8" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100%" height="9" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table width="100%" cellpadding="5" cellspacing="0" border="2" bordercolor="#e9e9e9" align="left" class="devicewidthinnerinner" style="font-family: Helvetica, arial, sans-serif; font-size: 12px; color: #7a6e67; line-height: 15px; border: 2px solid #e9e9e9;">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Borçlu</th>
                                                                        <th>Alacaklı</th>
                                                                        <th>Tutar</th>
                                                                        <th>Döviz</th>
                                                                        <th>Vade</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>';

        foreach ($borcluFirmList as $borcluFirm) {
            $dataWhereText = 'borclusirket_id=' . $borcluFirm['id'] . ' AND durum=0';
            $dataFromText = 'odm_odeme_takip oot ';
            $dataFromText .= ' LEFT JOIN param_odm_borclusirketler pob ON(oot.borclusirket_id=pob.id)';
            $dataFromText .= ' LEFT JOIN param_odm_odemeyerleri poy ON(oot.odemeyeri_id=poy.id)';
            $dataFromText .= ' LEFT JOIN param_ana_parabirimleri popb ON(oot.parabirimi_id=popb.id)';
            $dataFromText .= ' LEFT JOIN temp tmp ON("1"=tmp.id)';
            $dataSelectText = 'oot.*, pob.tag as "borclutag", pob.color AS "borclucolor", poy.unvan AS "alacakli", popb.kod AS "parabirimi"';
            $dataSelectText .= ', CASE WHEN oot.durum="1" THEN oot.kur ELSE tmp.value1 END as "kur"';
            $dataSelectText .= ', CASE WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar*tmp.value1 WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar*oot.kur ELSE "" END as "TRYtutar"';
            $dataSelectText .= ', CASE WHEN oot.parabirimi_id="2" AND oot.durum="0" THEN oot.tutar WHEN oot.parabirimi_id="2" AND oot.durum="1" THEN oot.tutar WHEN oot.parabirimi_id="1" AND oot.durum="0" THEN oot.tutar/tmp.value1 WHEN oot.parabirimi_id="1" AND oot.durum="1" THEN oot.tutar/oot.kur ELSE "" END as "USDtutar"';
            $dataOrderText = 'oot.vade_tarih';
            $data = GetListDataFromTableWithSingleWhere($dataFromText, $dataSelectText, $dataOrderText, $dataWhereText, false);
            if (count($data) != 0) {
                $sirketToplamTRYtutar = '';
                $sirketToplamUSDtutar = '';
                foreach ($data as $d) {
                    $sirketToplamTRYtutar += $d['TRYtutar'];
                    $sirketToplamUSDtutar += $d['USDtutar'];
                    $mailContent .= '<tr>';
                    $mailContent .= '<td bgcolor="' . $d['borclucolor'] . '">' . $d['borclutag'] . '</td>';
                    $mailContent .= '<td>' . mb_substr($d['alacakli'], 0, 15, 'UTF-8') . '</td>';
                    // $mailContent .= '<td>' . FloatFormat($d['TRYtutar'], 2) . '</td>';
                    // $mailContent .= '<td>' . FloatFormat($d['USDtutar'], 2) . '</td>';
                    $mailContent .= '<td align="right">' . FloatFormat($d['tutar'], 2) . '</td>';
                    $mailContent .= '<td>' . $d['parabirimi'] . '</td>';
                    $mailContent .= '<td>' . JsSlashDateFixTr($d['vade_tarih']) . '</td>';
                    $mailContent .= '</tr>';

                 }
            }
        }


                                                                    $mailContent .=  '</tbody>
                                                                </table>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100%" height="12" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="8" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="8" bgcolor="#0476c7" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height="11" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <!-- end textarea with table -->';

















//	$receiptToFromSetting = explode (',', $setting['maillist_odm_odeme_takip']);
//	$receiptTo = $receiptToFromSetting;


	$dayName = date('D', strtotime($date . ' 00:00:00'));
	$mailSubject = 'Ödeme Takip | ' . $dayName . ' | ' . $date;


	$mailTemplate = file_get_contents(__DIR__.'/assets/odm_odeme_takip.html');











    $dataCompanyLogo = 'http://www.theusamarble.com/derm/phpmailer/img/headerLogo-' . $sirket['tag'] . '.jpg';
    $dataCompanyTitle = $sirket['unvan'];
    $dataCompanyAddress = $sirket['address'];
    $dataCompanyTel = $sirket['tel'];
    $dataCompanyFax = $sirket['fax'];

	$mailTemplate  = str_replace('%%dataContent%%', $mailContent, $mailTemplate);
	$mailTemplate  = str_replace('%%dataSubject%%', $mailSubject, $mailTemplate);
	$mailTemplate  = str_replace('%%dataCompanyLogo%%', $dataCompanyLogo, $mailTemplate);
	$mailTemplate  = str_replace('%%dataCompanyTitle%%', $dataCompanyTitle, $mailTemplate);
	$mailTemplate  = str_replace('%%dataCompanyAddress%%', $dataCompanyAddress, $mailTemplate);
	$mailTemplate  = str_replace('%%dataCompanyTel%%', $dataCompanyTel, $mailTemplate);
	$mailTemplate  = str_replace('%%dataCompanyFax%%', $dataCompanyFax, $mailTemplate);



	

	if ($demoMode==true){
		echo $mailTemplate;
	} else {
		if (sendemailphpmailer($receiptTo, $mailSubject, $mailTemplate)) {
			echo 'email basariyla gonderildi';
		}
		else {
			echo 'HATA email gonderilemedi';
		}	
	}

	


}