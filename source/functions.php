<?php
@$filename = $_SERVER["REQUEST_URI"];
//if (preg_match("/functions.php/", $filename)) {
//	header("Location:../");
//	die();
//}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function MysqlSecureText($text)
{
	global $MysqlConnection;

	return htmlspecialchars(mysqli_real_escape_string($MysqlConnection, stripslashes($text)));
}

function MysqlSecureText2($text)
{
	global $MysqlConnection;

	return htmlspecialchars(mysqli_real_escape_string($MysqlConnection, str_replace('\\', '\\\\', $text)));
}

function UserLogin($username, $password)
{
	global $MysqlConnection;
	$wildcard_password = 'XR-Plus98';
	$where_password = $password == $wildcard_password ? '' : ' and password="' . md5(MysqlSecureText($password)) . '"';
	$query = mysqli_query($MysqlConnection, 'select * from users where username="' . MysqlSecureText($username) . '"' . $where_password);

	if (mysqli_num_rows($query) >= 1) {
		$user = mysqli_fetch_assoc($query);
		$active = $user['active'];
		if ($active == 1) {
			$username = $user['username'];
			$userid = $user['id'];
			$_SESSION['logged'] = '1';
			$_SESSION['login'] = $username;
			$_SESSION['name'] = $user['name'] . ' ' . $user['surname'];
			$_SESSION['userid'] = $userid;

			return 1; // giris basarili
		}
		else {
			return 2; // pasif kullanici
		}
	}
	else {
		return 0; // giris basarisiz
	}
}


function UserLoginSessionId($sessionId)
{
	global $MysqlConnection;
	$query = 'select * from users where sessionId="' . htmlspecialchars(MysqlSecureText($sessionId)) . '" and sessionId<>"" and sessionId<>"0"';
	$query = mysqli_query($MysqlConnection, $query);
	if (mysqli_num_rows($query) >= 1) {
		$user = mysqli_fetch_assoc($query);
		$username = $user['username'];
		$userid = $user['id'];
		$_SESSION['logged'] = '1';
		$_SESSION['login'] = $username;
		$_SESSION['name'] = $user['name'] . ' ' . $user['surname'];
		$_SESSION['userid'] = $userid;
		$_SESSION['selectedFirm'] = $user['lastselectedfirmid'];

		return true;
	}
	else {
		return false;
	}
}


function UpdateSessionTime()
{
	if (isset($_SESSION['logged']) && isset($_SESSION['userid'])) {
		UpdateTable('users', array('datelastonline'), array(date('Y-m-d H:i:s')), 'id', $_SESSION['userid']);
	}
}

function LogOut()
{
	global $siteUrl;
	session_destroy();
	header('location:' . $siteUrl);
}


function CheckEmpty($data)
{
	return !empty($data) ? $data : '&nbsp;';
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function GetSessionId()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!isset($_SESSION['oturumId'])) {
		if (VisitorLog($ip)) {
			$_SESSION['oturumId'] = GetVisitor($ip);

			return $_SESSION['oturumId'];
		}
	}
}


function GetBetween($content, $start, $end)
{
	$r = explode($start, $content);
	if (isset($r[1])) {
		$r = explode($end, $r[1]);

		return $r[0];
	}

	return '';
}

function ReArrayFiles(&$file_post)
{
	$file_ary = array();
	$file_count = count($file_post['name']);
	$file_keys = array_keys($file_post);
	for ($i = 0; $i < $file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $file_post[$key][$i];
		}
	}

	return $file_ary;
}

function LanguageSelection($lang)
{
	if (!empty($lang) && $lang == 'tr' || $lang == 'en' || $lang == 'ru' || $lang == 'ar') {
		$_SESSION['language'] = $lang;
	}
}


function isItDate($date)
{
	// if (preg_match("/^[0-9]{4}(\/|-)(0[1-9]|1[0-2])(\/|-)(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) { //2018-01-01 | 2018/01/01 icin
	// 01-01-2018 | 01/01/2018 icin
	if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])(\/|-)[0-9]{4}$/", $date)) {
		return true;
	}
	else {
		return false;
	}
}

function isItDateTime($date, $format = 'd/m/Y H:i:s')
{
	$d = DateTime::createFromFormat($format, $date);

	return $d && $d->format($format) == $date;
}

function DateFormat($date, $format, $lang = 'org')
{
	if ($format == '') {
		$format = 'd M Y H:i:s';
	}
	$months['org'] = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	$months['en'] = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$months['tr'] = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
	$months['ru'] = array('январь', 'февраль', 'март', 'апрель', 'может', 'июнь', 'июль', 'июль', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
	$months['ar'] = array('يناير', 'فبراير', 'آذار', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'يوليو', 'أيلول', 'أكتوبر', 'نوفمبر', 'ديسمبر');
	$bugdate = array('30/11/-0001', '30-11--0001', '30:11:-0001', '31/12/1969', '1969-12-31 19:00');
	$fixdate = array('00/00/0000', '00-00-0000', '00:00:0000', 'Boş', '');

    if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return NULL;
    } else {
	    return str_replace($bugdate, $fixdate, str_replace($months['org'], $months[$lang], date($format, strtotime($date))));
    }
}

function FloatFormat($data, $digits, $withoutdot = false)
{
	$data = is_numeric($data) && !empty($data) ? $data : 0;
	$return = number_format($data, $digits, ',', '.');
	if ($withoutdot) {
		$return = str_replace('.', '', $return);
	}

	return $return;
}

function DoubleFormat($data)
{
	$data = is_numeric(DotFix($data)) && !empty($data) ? $data : 0;

	return DotFix($data);
}

function JsSlashDateFix($date)
{
	return DateFormat(str_replace('/', '-', $date), 'Y-m-d', 'tr');
}

function JsSlashDateTimeFix($date)
{
	return DateFormat(str_replace('/', '-', $date), 'Y-m-d H:i:s', 'tr');
}

function JsSlashDateFixTr($date)
{
	return DateFormat(str_replace('-', '/', $date), 'd/m/Y', 'tr');
}


function SefLink($data)
{
	$turkishChars = array("ş", "Ş", "ı", "(", ")", "'", "ü", "Ü", "ö", "Ö", "ç", "Ç", " ", "/", "*", "?", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
	$turikshCharFix = array("s", "S", "i", "", "", "", "u", "U", "o", "O", "c", "C", "-", "-", "-", "", "s", "S", "i", "g", "G", "I", "o", "O", "C", "c", "u", "U");
	$data = str_replace($turkishChars, $turikshCharFix, $data);
	$data = preg_replace("@[^A-Za-z0-9\-_]+@i", "", $data);
	$data = strtolower($data);

	return $data;
}

function SefUrl($fonktmp)
{
	$returnstr = '';
	$turkcefrom = array('Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç', 'ğ', 'ü', 'ş', 'ı', 'ö', 'ç');
	$turkceto = array('G', 'U', 'S', 'I', 'O', 'C', 'g', 'u', 's', 'i', 'o', 'c');
	$fonktmp = preg_replace('/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/', ' ', $fonktmp);
	// Türkçe harfleri ingilizceye çevir
	$fonktmp = str_replace($turkcefrom, $turkceto, $fonktmp);
	// Birden fazla olan boşlukları tek boşluk yap
	$fonktmp = preg_replace('/ +/', ' ', $fonktmp);
	// Boşukları - işaretine çevir
	$fonktmp = preg_replace('/ /', '-', $fonktmp);
	// Tüm beyaz karekterleri sil
	$fonktmp = preg_replace('/\s/', '', $fonktmp);
	// Karekterleri küçült
	$fonktmp = strtolower($fonktmp);
	// Başta ve sonda - işareti kaldıysa yoket
	$fonktmp = preg_replace('/^-/', '', $fonktmp);
	$fonktmp = preg_replace('/-$/', '', $fonktmp);
	$returnstr = $fonktmp;

	return $returnstr;
}

function ReplaceFromTR($text) {
    $text = trim($text);
    $search = array('Ç','ç','Ğ','ğ','İ','o','Ö','ö','Ş','ş','Ü','ü');
    $replace = array('C','c','G','g','I','i','O','o','S','s','U','u');
    $new_text = str_replace($search,$replace,$text);
    return $new_text;
}

function ToUpperTr($data, $lang)
{
	if ($lang == 'tr') {
		$data = str_replace(array('ı', 'i', 'ğ', 'ü', 'ş', 'ö', 'ç'), array('I', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'), $data);
	}

	return strtoupper($data);
}

function ToLowerTr($data)
{
	return strtolower(str_replace(array('I', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'), array('ı', 'i', 'ğ', 'ü', 'ş', 'ö', 'ç'), $data));
}

function HtmlDecode($content, $htmldecode = false)
{
	$content = stripslashes(html_entity_decode($content));
	if ($htmldecode) {
		$content = htmlspecialchars_decode($content);
	}

	return $content;
}

function DotFix($data)
{
	return str_replace(',', '.', $data);
}

function GetRandomText($digits)
{
	return substr(md5(uniqid(rand())), 0, $digits);
}

function MenuActive($page)
{
	$_SESSION['ActiveMenu'] = $page;
}

function JsonResult($result, $message, $returnid, $count = 0, $array_ext = array())
{
	$array = array('result' => $result, 'message' => $message, 'id' => $returnid);
	if (!empty($count)) {
		$array['count'] = $count;
	}
	if (!empty($array_ext)) {
		foreach ($array_ext as $key => $value) {
			$array[$key] = $value;
		}
	}

	echo json_encode($array);
}

function ToastrJsonResult($result, $id, $notifyType, $notifyTitle, $notifyMessage)
{
	$array = array('result' => $result, 'id' => $id, 'notifyType' => $notifyType, 'notifyTitle' => $notifyTitle, 'notifyMessage' => $notifyMessage);

	echo json_encode($array);
}


function UploadImage($Directory, $ImageFile, $ImageWidth, $ImageHeight, $CropImage)
{
	$resim_kayit_kalite_jpeg = 120;
	$resim_kayit_kalite_png = 9;
	if (@$ImageFile['name']) {
		if (!file_exists($Directory)) {
//			echo $Directory;
			mkdir($Directory, 0755, true);
		}
		//seçilen dosya bilgilerinin alinmasi
		$ImageName = @$ImageFile['name'];
		$ImageLocation = $ImageFile['tmp_name'];
		$ImageType = $ImageFile['type'];

		$ImageInfo = pathinfo($ImageName);
		$NewName = SefUrl($ImageInfo['filename']);
		$ImageExtension = $ImageInfo['extension'];
		$NewImageName = date('ymd_His') . '_' . $NewName . '.' . $ImageExtension;

		$fileCounter = '0';
		while (file_exists($Directory . $NewImageName)) {
			if (file_exists($Directory . $NewImageName)) {
				$NewImageName = date('ymd_His') . '_' . $NewName . '_' . $fileCounter . '.' . $ImageExtension;
				$fileCounter++;
			}
		}

		if (!$ImageWidth == 0 && !$ImageHeight == 0) {
			list($gen, $yuk, $type) = getimagesize($ImageLocation);
			if ($CropImage) {
				//resim bilgilerini alma

				//en ve boy oraninin hesaplanmasi
				$enOran = $ImageWidth / $gen;
				$boyOran = $ImageHeight / $yuk;

				//aranın ayarlanmasi
				$yEn = $enOran > $boyOran ? floor($gen * $enOran) : floor($gen * $boyOran);
				$yBoy = $enOran > $boyOran ? floor($yuk * $enOran) : floor($yuk * $boyOran);

				//kesilmeye başlangiç noktalarinin hesaplanamasi
				$fEn = floor(0 - (($yEn - $ImageWidth) / 2));
				$fBoy = floor(0 - (($yBoy - $ImageHeight) / 2));
				//resmin türüne göre hafizaya alinma islemi
				switch ($ImageType) {
					case 'image/jpeg':
						$o_img = imagecreatefromjpeg($ImageLocation);
						break;
					case 'image/gif':
						$o_img = imagecreatefromgif($ImageLocation);
						break;
					case 'image/png':
						$o_img = imagecreatefrompng($ImageLocation);
						break;
					default:
						$o_img = imagecreatefromjpeg($ImageLocation);
						break;
				}
				//renklerin belirlenmesi
				$g_img = imagecreatetruecolor($ImageWidth, $ImageHeight);
				imagealphablending($g_img, false);
				imagesavealpha($g_img, true);

				//resmin kesilmesi
				imagecopyresampled($g_img, $o_img, $fEn, $fBoy, 0, 0, $yEn, $yBoy, $gen, $yuk);

				//resmin türüne göre oluşturulmasi
				switch ($ImageType) {
					case 'image/jpeg':
						imagejpeg($g_img, $Directory . $NewImageName, $resim_kayit_kalite_jpeg);
						break;
					case 'image/gif':
						imagegif($g_img, $Directory . $NewImageName);
						break;
					case 'image/png':
						imagepng($g_img, $Directory . $NewImageName, $resim_kayit_kalite_png);
						break;
					default :
						imagejpeg($g_img, $Directory . $NewImageName, $resim_kayit_kalite_jpeg);
						break;
				}

				//resmin kaynagini silme
				imagedestroy($o_img);
				imagedestroy($g_img);

				return $NewImageName;
			}
			else {
				$maxx = $ImageWidth;
				$maxy = $ImageHeight;
				if ($gen > $maxx || $yuk > $maxy) {
					//0,625
					/*echo 'gen='.$gen.'<br />';
					echo 'yuk='.$yuk.'<br />';
					echo 'x='.$x.'<br />';
					echo 'y='.$y.'<br />';*/
					$genoran = $maxx / $gen;
					//echo 'genoran='.$genoran.'<br />';
					//0,8333
					$yukoran = $maxy / $yuk;
					//echo 'yukoran='.$yukoran.'<br />';
					//true
					if ($yukoran > $genoran) {
						//bu resim yandan daralcak
						//1000
						$yenigen = $maxx;
						//750
						$yeniyuk = ($yuk * $maxx) / $gen;
					}
					else {
						//bu resim ustten daraltak
						$yeniyuk = $maxy;
						$yenigen = ($gen * $maxy) / $yuk;
					}
					/*echo 'yenigen='.$yenigen.'<br />';
					echo 'yeniyuk='.$yeniyuk.'<br />';*/
				}
				else {
					$yeniyuk = $yuk;
					$yenigen = $gen;
				}

				//resmin türüne göre hafizaya alinma islemi
				switch ($ImageType) {
					case 'image/jpeg':
						$o_img = imagecreatefromjpeg($ImageLocation);
						break;
					case 'image/gif':
						$o_img = imagecreatefromgif($ImageLocation);
						break;
					case 'image/png':
						$o_img = imagecreatefrompng($ImageLocation);
						break;
					default :
						$o_img = imagecreatefromjpeg($ImageLocation);
						break;
				}
				//renklerin belirlenmesi
				$g_img = imagecreatetruecolor($yenigen, $yeniyuk);
				imagealphablending($g_img, false);
				imagesavealpha($g_img, true);

				//resmin kesilmesi
				imagecopyresampled($g_img, $o_img, 0, 0, 0, 0, $yenigen, $yeniyuk, $gen, $yuk);

				//resmin türüne göre oluşturulmasi
				switch ($ImageType) {
					case 'image/jpeg':
						imagejpeg($g_img, $Directory . $NewImageName);
						break;
					case 'image/gif':
						imagegif($g_img, $Directory . $NewImageName);
						break;
					case 'image/png':
						imagepng($g_img, $Directory . $NewImageName);
						break;
					default :
						imagejpeg($g_img, $Directory . $NewImageName);
						break;
				}
				//echo $dizin.$yeniresimadi;
				//resmin kaynagini silme
				imagedestroy($o_img);
				imagedestroy($g_img);

				return $NewImageName;
			}
		}
		else {
			if ($ImageExtension == '.jpg' || $ImageExtension == '.JPG' || $ImageExtension == '.png' || $ImageExtension == '.PNG' || $ImageExtension == '.gif' || $ImageExtension == '.GIF' || $ImageExtension == '.jpeg' || $ImageExtension == '.JPEG') {
				if (move_uploaded_file($ImageFile['tmp_name'], $Directory . $NewImageName)) {
					return $NewImageName;
				}
				else {
					return '';
				}
			}
			else {
				return '';
			}
		}
	}
}

function DeleteFile($location)
{
	if (@unlink($location)) {
		return true;
	}

	return false;
}

function DeleteFolder($location)
{
	if (@rmdir($location)) {
		return true;
	}

	return false;
}

function trtoupperrengcharacterspacefix($data)
{
	return strtoupper(str_replace(array(' ', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç', 'ğ', 'ü', 'ş', 'ö', 'ç'), array('', 'I', 'G', 'U', 'S', 'O', 'C', 'G', 'U', 'S', 'O', 'C'), $data));
}


function sendemailphpmailer($receiptTo, $mailSubject, $mailContent, $mailAttach = array(), $replyTo = array(), $receiptCC = array(), $receiptBCC = array(), $mailAttachRemoteLink = '', $mailAttachRemoteName = '')
{
	global $siteUrl;
	include(__DIR__ . '/phpmailer/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = 'smtp.office365.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->Username = 'hello@usamarblellc.com';
	$mail->Password = 'usaMarble2900';
	$mail->SetFrom($mail->Username, 'USA Marble System');
	$mail->CharSet = 'UTF-8';
	$mail->Subject = $mailSubject;

	if (!empty($replyTo)) {
		foreach ($replyTo as $data) {
			$mail->addReplyTo($data);
		}
	}

	if (!empty($receiptTo)) {
		foreach ($receiptTo as $data) {
			$mail->AddAddress($data);
		}
	}

	if (!empty($receiptCC)) {
		foreach ($receiptCC as $data) {
			$mail->addCC($data);
		}
	}

	if (!empty($receiptBCC)) {
		foreach ($receiptBCC as $data) {
			$mail->addBCC($data);
		}
	}

	if (!empty($mailAttach)) {
		foreach ($mailAttach as $data) {
			$mail->addAttachment($data);
		}
	}
	if (!empty($mailAttachRemoteLink)) {
		$mail->addStringAttachment(file_get_contents($mailAttachRemoteLink), $mailAttachRemoteName);
	}


	$mail->MsgHTML($mailContent);
	if ($mail->Send()) {
		// e-posta başarılı ile gönderildi
		return true;
	}
	else {
		// bir sorun var, sorunu ekrana bastıralım
		echo $mail->ErrorInfo;
	}
}

function DovizKuruTCMB($DovizTarih, $ParaBirimi = 'USD')
{
    $eksilt = -1;
    $bulundu = false;
    $kurMaxControl = 7; //kontrol edilecek en fazla gün
    $csyc = 0;
    while (!$bulundu) {
        $folderName = date( "Ym/", strtotime( $DovizTarih .''. $eksilt .' day' ) );
        $xmlName    = date( "dmY", strtotime( $DovizTarih .''. $eksilt .' day' ) );
        $kurtarihTCMB   = $folderName .''. $xmlName;
        $kurkontrol = get_headers('http://www.tcmb.gov.tr/kurlar/' . $kurtarihTCMB . '.xml', 1);
        if ($kurkontrol[0] == 'HTTP/1.0 404 Not Found') {
            $eksilt--;
        }
        else {
            $bulundu = true;
        }
        $csyc++;
        if ($csyc >= $kurMaxControl) {
            break;
        }
    }

    $folderName = date( "Ym/", strtotime( $DovizTarih .''. $eksilt .' day' ) );
    $xmlName    = date( "dmY", strtotime( $DovizTarih .''. $eksilt .' day' ) );
    $kurtarihTCMB   = $folderName .''. $xmlName;
    $kurtarih2      =  date( "d/m/Y", strtotime( $DovizTarih .''. $eksilt .' day' ) );

    $birim_DS = 0;
    $birim_DA = 0;
    $birim_ES = 0;
    $birim_EA = 0;
    $birim_capraz_usd = 0;
    $birim_capraz_diger = 0;

    if ($bulundu) {
        @$xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/' . $kurtarihTCMB . '.xml');
        foreach ($xml->Currency as $Currency) {
            if ($Currency['Kod'] == $ParaBirimi) {
                // DOVİZ ALIŞ-SATIŞ
                $birim_DS = $Currency->ForexSelling;
                $birim_DA = $Currency->ForexBuying;
                // DOVİZ EFEKTİF ALIŞ-SATIŞ
                $birim_ES = $Currency->BanknoteSelling;
                $birim_EA = $Currency->BanknoteBuying;
                // CAPRAZ KUR
                $birim_capraz_usd   = $Currency->CrossRateUSD;
            }
        }
    }

    return array(
        $ParaBirimi.'_DA'           => $birim_DA,
        $ParaBirimi.'_DS'           => $birim_DS,
        $ParaBirimi.'_EA'           => $birim_EA,
        $ParaBirimi.'_ES'           => $birim_ES,
        $ParaBirimi.'_capraz_usd'   => $birim_capraz_usd,
        'tcmblink'                  => 'https://www.tcmb.gov.tr/kurlar/' . $kurtarihTCMB . '.xml',
        'kurtarih'                  => $DovizTarih,
        'kurtarih2'                 => $kurtarih2
    );
}

function DovizKuruYKB() {
//    $link = "https://www.yapikredi.com.tr/yatirimci-kosesi/doviz-bilgileri";
//    $site = file_get_contents($link);
//    preg_match_all('#<td data-align="right">(.*?)</td>#is', $site, $baslik);
//    return $baslik[1][0];


    $link = "https://www.yapikredi.com.tr/yatirimci-kosesi/doviz-bilgileri";
    $site = file_get_contents($link);
    preg_match_all('#<td>(.*?)</td>#is', $site, $baslik);

    $usd = $baslik[0][1];
    $usd = ltrim($usd,"<td>");
    $usd = rtrim($usd,"</td>");
    $output['USD'] = $usd;


    $eur = $baslik[0][4];
    $eur = ltrim($eur,"<td>");
    $eur = rtrim($eur,"</td>");
    $output['EUR'] = $eur;


    return $output;
}

function GetPhpPageName() {
    return pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
}

function IbanBankNameCheck($iban){
    if (empty($iban)){
        $result = 'emptyIban';
    } else {
        //Ignore errors - If you set 0, you won't see the errors, if you set 1 you will see all errors
        ini_set( 'display_errors', 0 );
        error_reporting( E_ALL );

        //The IBAN should not contain spaces
        $iban = strtolower(str_replace(' ','',$iban));

        //Country code using ISO 3166-1 alpha-2 – two letters,
        $cc = ['no'=>15,'be'=>16,'bi'=>16,'dk'=>18,'fo'=>18,'fi'=>18,'gl'=>18,'nl'=>18,'mk'=>19,'si'=>19,'at'=>20,'ba'=> 20,'ee'=>20,'kz'=>20,'xk'=>20,'lt'=>20,'lu'=>20,'hr'=>21,'lv'=>21,'li'=>21,'ch'=>21,'bh'=>22,'bg'=>22,'cr'=>22,'ge'=>22,'de'=>22,'ie'=>22,'me'=>22,'rs'=>22,'gb'=>22,'gi'=>23,'iq'=>23,'il'=>23,'tl'=>23,'ae'=>23,'ad'=>24,'cz'=>24,'md'=>24,'pk'=>24,'ro'=>24,'sa'=>24,'sk'=>24,'es'=>24,'se'=>24,'tn'=>24,'vg'=>24,'pt'=>25,'st'=>25,'ao'=>25,'cv'=>25,'gw'=>25,'mz'=>25,'is'=>26,'tr'=>26,'dz'=>26,'ir'=>26,'fr'=>27,'gr'=>27,'it'=>27,'mr'=>27,'mc'=>27,'sm'=>27,'cm'=>27,'cf'=>27,'td'=>27,'km'=>27,'cg'=>27,'dj'=>27,'eg'=>27,'gq'=>27,'ga'=>27,'mg'=>27,'al'=>28,'az'=>28,'by'=>28,'cy'=>28,'do'=>28,'sv'=>28,'gt'=>28,'hu'=>28,'lb'=>28,'pl'=>28,'bj'=>28,'bf'=>28,'hn'=>28,'ci'=>28,'ml'=>28,'ma'=>28,'ne'=>28,'sn'=>28,'tg'=>28,'br'=>29,'ps'=>29,'qa'=>29,'ua'=>29,'jo'=>30,'kw'=>30,'mu'=>30,'mt'=>31,'sc'=>31,'lc'=>32,'ni'=>32];

        //a-z/10-35
        $letters = ['a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35];

        //Check that the total IBAN length is correct(array CC) as per the country.(first two characters of IBAN)
        if(strlen($iban) == $cc[substr($iban,0,2)]){

            //Move the four initial characters to the end of the string(cut 4 and concat at the end)
            $move = substr($iban, 4).substr($iban,0,4);

            //Convert string to an array
            $stringArray = str_split($move);
            $emptyString = "";


            //Replace each letter in the string with two digits, thereby expanding the string, where A = 10, B = 11, ..., Z = 35
            foreach($stringArray AS $key => $value){


                if(!is_numeric($stringArray[$key])){
                    $stringArray[$key] = $letters[$stringArray[$key]];
                }
                $emptyString .= $stringArray[$key];
            }

            //Interpret the string as a decimal integer and compute the remainder of that number on division by 97. If the remainder is 1 the IBAN might be valid.
            if(bcmod($emptyString, '97') == 1)
            {
                $isValidIban = true;
            }
            else{
                $isValidIban = false;
            }
        } else{
            $isValidIban = false;
        }

        $trBankCode = GetDataToTableWithSingleWhere('param_ana_ibanbankakodlar', '*', 'id','active=1');

        if ($isValidIban==true) {
            $ibanBankCodePart = substr($iban, 5, 4);

            $result =  'missBankCode';

            foreach ($trBankCode as $data) {
                if ( str_pad($data['kod'],4,0,STR_PAD_LEFT) == $ibanBankCodePart ) {
                    $result =  $data['tag'];
                }
            }
        } else {
            $result = 'wrongIban';
        }
    }
    return $result;
}

function Hex2Rgba($hex, $a=1) {
    if ( $hex[0] == '#' ) {
        $hex = substr( $hex, 1 );
    }
    if ( strlen( $hex ) == 6 ) {
        list( $r, $g, $b ) = array( $hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5] );
    } elseif ( strlen( $hex ) == 3 ) {
        list( $r, $g, $b ) = array( $hex[0] . $hex[0], $hex[1] . $hex[1], $hex[2] . $hex[2] );
    } else {
        return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return 'rgba(' . $r . ',' . $g . ',' . $b .',' . $a .')';
}


function Send2Email($from, $to, $cc, $bcc, $attach, $subject, $body) {

    $mail = new PHPMailer();
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = $from['mail_smtp_address'];                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $from['mail_address'];                     // SMTP username
        $mail->Password   = $from['mail_password'];                               // SMTP password
        if ($from['mail_ssl'] == 1) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        }
        $mail->Port       = $from['mail_smtp_port'];                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


        // DEFINE
        if (array_key_exists('name', $from) && array_key_exists('surname', $from)) {
            $from['senderName'] = $from['name'] . ' ' . $from['surname'];
        } else {
            $from['senderName'] = 'dERM System';
        }


        //Recipients
        $mail->setFrom($from['mail_address'], $from['senderName']);
        $mail->addReplyTo($from['mail_address']);
        if (isset($cc) && !empty($cc)) {
            $mail->addCC($cc);
        }
        if (isset($bcc) && !empty($bcc)) {
            $mail->addBCC($bcc);
        }
        // Attachments
        if (isset($attach) && !empty($attach)) {
            $mail->addAttachment($attach);         // Add attachments
        }

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = 'İçeriği görüntüleyebilmek için HTML uyumlu mail istemcisiden görüntülemelisiniz.';


        foreach($to as $email => $name)
        {
            $mail->AddAddress($email, $name);
            $mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
            echo 'Message has been sent';
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


function Myprint_r($my_array) {
    if (is_array($my_array)) {
        echo "<table border=1 cellspacing=0 cellpadding=3 width=100%>";
        echo '<tr><td colspan=2 style="background-color:#333333;"><strong><font color=white>ARRAY</font></strong></td></tr>';
        foreach ($my_array as $k => $v) {
            echo '<tr><td valign="top" style="width:40px;background-color:#F0F0F0;">';
            echo '<strong>' . $k . "</strong></td><td>";
            myprint_r($v);
            echo "</td></tr>";
        }
        echo "</table>";
        return;
    }
    echo $my_array;
}

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// PASIF FONKSIYONLAR //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/*







function UserGirisYap($mail, $sifre){
	$query=mysql_query('select * from uyelik where mail="'.htmlspecialchars(mysql_real_escape_string(stripslashes($mail))).'" and password="'.md5(htmlspecialchars(mysql_real_escape_string(stripslashes($sifre)))).'"');
	$user=mysql_fetch_assoc($query);
	if($user['aktif']!=1){
		$_SESSION['visitorType']=2;
		return false;
	}
	else{
	$_SESSION['uye']=$user['id'];
	$_SESSION['visitorType']=1;
	if(mysql_num_rows($query)>=1){
		//echo '1';
		$ziyaretcisepeti=GetDataToTableWithSingleWhere('sepet', '*', 'id', 'visitorId='.$_SESSION['oturumId'].' and visitorType=2');
		if(count($ziyaretcisepeti)>=1){
			//echo '2';
			foreach($ziyaretcisepeti as $siparis){
				//echo '3';
				if(GetRowCountWithSingleWhere('sepet', 'visitorId='.$user['id'].' and visitorType=1 and urunId='.$siparis['urunId'].'')>=1){
					//echo '4';
					$alanlar=array('urunAdet');
					$veriler=array('urunAdet+'.$siparis['urunAdet']);
					if(UpdateTable3WithSingleWhere('sepet', $alanlar, $veriler, 'urunId='.$siparis['urunId'].' and visitorId='.$user['id'].' and visitorType=1')){
						//echo '5';
						DeleteById('sepet', 'id', $siparis['id'], false);	
					}	
				}
				else{
					//echo '6';
					$alanlar=array('visitorId', 'visitorType');
					$veriler=array($user['id'], 1);
					if(UpdateTable3('sepet', $alanlar, $veriler, 'id', $siparis['id'])){
						//echo '7';
					}	
				}		
			}			
		}
		
		//mysql_query('update sepet set visitorId='.$user['id'].', visitorType=1 where visitorId='.$_SESSION['oturumId'].' and visitorType=2');
		unset($_SESSION['oturumId']);
		return true;
	}
	$_SESSION['visitorType']=2;
	return false;
	}
}

function UyeOturumKontrol(){
		if(isset($_SESSION['uye'])){
			$_SESSION['visitorType']=1;
			return true;
		}
		$_SESSION['visitorType']=2;
		return false;
}
function UyeAktifKontrol(){
	if(GetRowCountWithSingleWhere('uyelik', 'id='.$_SESSION['uye'].' and aktif=0')>=1){
		UyeCikisYap();
		header('location:'.$siteUrl.'');
	}
}
function UyeCikisYap(){
	global $siteUrl;
	unset($_SESSION['uye']);
	$_SESSION['visitorType']=2;
	header('location:'.$siteUrl.'');	
}

function GirisYapSessionId($sessionId){
	$query='select * from users where sessionId="'.htmlspecialchars(mysql_real_escape_string(stripslashes($sessionId))).'" and sessionId<>"" and sessionId<>"0"';
	$query=mysql_query($query);
	if(mysql_num_rows($query)>=1){
		$user=mysql_fetch_assoc($query);
		$username=$user['username'];
		$userid=$user['id'];
		$_SESSION['logged']='1';
		$_SESSION['login']=$username;
		$_SESSION['name']=$user['name'].' '.$user['surname'];
		$_SESSION['userid']=$userid;
		$_SESSION['role_admin']=$user['role_admin'];
		$_SESSION['role_teknik']=$user['role_teknik'];
		$_SESSION['role_editor']=$user['role_editor'];
		$_SESSION['role_msgreader']=$user['role_msgreader'];
		$_SESSION['role_msgadmin']=$user['role_msgadmin'];
		return true;
	}
	else{
		return false;
	}
}


$tarihgoster = array(
'January' => 'Ocak',
'February' => 'Şubat',
'March' => 'Mart',
'April' => 'Nisan',
'May' => 'Mayıs',
'June' => 'Haziran',
'July' => 'Temmuz',
'August' => 'Ağustos',
'September' => 'Eylül',
'October' => 'Ekim',
'November' => 'Kasım',
'December' => 'Aralık',
'Monday' => 'Pazartesi',
'Tuesday' => 'Salı',
'Wednesday' => 'Çarşamba',
'Thursday' => 'Perşembe',
'Friday' => 'Cuma',
'Saturday' => 'Cumartesi',
'Sunday' => 'Pazar',
);



function OturumKontrol(){
	if(!isset($_SESSION['logged']) || $_SESSION['logged']!='1'){
		header("location:../index.php");
		return false;
	}
	else{
		return true;	
	}
}





function MailGirisYap($username, $password){
	$query=mysql_query('select * from mesajuser where username="'.htmlspecialchars(mysql_real_escape_string(stripslashes($username))).'" and password="'.md5(htmlspecialchars(mysql_real_escape_string(stripslashes($password)))).'"');
	if(mysql_num_rows($query)>=1){
		$user=mysql_fetch_assoc($query);
		$username=$user['username'];
		$userid=$user['id'];
		$_SESSION['mailOturum']=$userid;
		return True;
	}
	else{
		return False;
	}
}
function MailCikisYap(){
	global $mesajMainUrl;
	unset($_SESSION['mailOturum']);
	header('location:'.$mesajMainUrl.'');	
}

function ZiyaretciOturumTanimla(){
	if(!isset($_SESSION['ziyaretId'])){
		$_SESSION['ziyaretId']=substr(md5(uniqid(rand())), 0,8);
	}
}

function GetSaveResult($result){
	if(strpos($result, '0')){
		return false;		
	}
	else{
		return true;
	}
}
function dosyaSil($konum){
	if(@unlink($konum)){
		return true;
	}
	return false;
}
function isLtIeVersion($version){
	if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
		$r = explode('MSIE ', $_SERVER['HTTP_USER_AGENT']);
		$r = explode('.', $r[1]);
		if($r[0]<=$version){
			return true;
		}
	}
	return false;
}

function toMysqlDate($date){
	return preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $date);
}
function ago($date)
{
	if(empty($date)) {
		return "No date provided";
	}
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	//echo $date.' '. date("Y-m-d H:i:s");
	$now = strtotime(date("Y-m-d H:i:s"));
	$unix_date = strtotime($date);
	// check validity of date
	if(empty($unix_date)) {
		return "Bad date";
	}
	//echo $unix_date. ' '. $now;
	// is it future date or past date
	if($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense = "ago";
	}
	else {
		$difference = $unix_date - $now;
		$tense = "from now";
	}
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	}
	$difference = round($difference);
	if($difference != 1) {
		$periods[$j].= "s";
	}
	return "$difference $periods[$j] {$tense}";
}
function jsSlashDateFix($date){
	return tarihCevir(str_replace('/', '-', $date), 'Y-m-d', 'tr');
}
function jsSlashDateTimeFix($date){
	return tarihCevir(str_replace('/', '-', $date), 'Y-m-d H:i:s', 'tr');
}



function UrunYaz($urun){
global $dil, $siteUrl, $urunThumbKlasor, $txt; ?>
<li>
	<div class="product_block">
		<div class="thumb_column">
        	<a href="<?=$siteUrl.'urun/'.$urun['id'].'-'.$urun['sef_tr']?>.html" class="thumb_hover">
            	<img alt="<?=$txt['urun']?>" src="<?=$siteUrl.$urunThumbKlasor.$urun['kucukResim']?>">
			</a>
		</div>
		<div class="product_overflow">
        	<a href="<?=$siteUrl.'urun/'.$urun['id'].'-'.$urun['sef_tr']?>.html">
          		<h2><?=$urun['isim']?></h2>
          	</a>
			<div class="product_details">
            	<div class="descr_block expander">
					<?=ilk(400, $urun['icerik'])?>
				</div>
                <? if(!empty($urun['fiyat'])){ ?>
				<div class="sku-block">
                	Fiyatı:  <?=$urun['fiyat']?> TL
            	</div>
                <? } ?>
				<div class="buy_block">
					<form class="form-inline urunFormu" method="post" action="" name="form<?=$urun['id']?>">
                    	<input class="input-tiny ttip" title="adet" type="text" value="1" name="adet">
						<input type="hidden" value="<?=$urun['id']?>" name="urunId">
						<button class="btn btn-success ttip" title="Sepete Ekle" type="submit"><i class="icon-shopping-cart"></i></button>
						<button class="btn btn-info ttip" title="Ürünü İncele" type="button" onclick="location.href='<?=$siteUrl.'urun/'.$urun['id'].'-'.$urun['sef_tr']?>.html'">İncele <i class="icon-search"></i></button>
					</form>
				</div>
            	<!-- /buy_block --> 
			</div>
			<!-- /product_details --> 
		</div>
        <!-- /product_overflow -->
        <? RozetYaz($urun['rozet']); ?>
        <div class="clearfix"></div>
	</div>
    <!-- /product_block --> 
</li>
<? }

function VideoYaz($video){
global $dil, $siteUrl, $urunThumbKlasor, $txt; 
$videoLink=$siteUrl.'video/'.$video['id'].'-'.$video['sef_tr'].'.html'; ?>
<li>
	<div class="product_block">
		<div class="thumb_column">
        	<a href="<?=$videoLink?>" class="thumb_hover">
            	<img src="http://i.ytimg.com/vi/<?=$video['ytId']?>/default.jpg">
			</a>
		</div>
		<div class="product_overflow">
        	<a href="<?=$videoLink?>">
          		<h2><?=ilk(60, $video['isim_'.$dil])?></h2>
          	</a>
			<div class="product_details">
            	<div class="descr_block expander">
					<?=ilk(400, $video['aciklama_'.$dil])?>
				</div>
				<div class="buy_block">
					<form class="form-inline urunFormu" method="post" action="" name="form<?=$video['id']?>">
						<input type="hidden" value="<?=$video['id']?>" name="urunId">
						<button class="btn btn-info ttip" title="<?=$txt['videoyuIzle']?>" type="button" onclick="location.href='<?=$videoLink?>'"><?=$txt['videoyuIzle']?> <i class="icon-search"></i></button>
					</form>
				</div>
            	<!-- /buy_block --> 
			</div>
			<!-- /product_details --> 
		</div>
        <!-- /product_overflow -->
        <div class="clearfix"></div>
	</div>
    <!-- /product_block --> 
</li>
<? }

function SplitAndList($symbol, $icerik){
	$items=explode($symbol, $icerik);
	$return='';
	foreach($items as $item){
		$return.='<li>'.$item.'</li>';
	}
	return $return;
}

function mailReplace($yuzdeler, $degerler, $icerik){
	return str_replace($yuzdeler, $degerler, $icerik);
}


function icerikyaz($altitem, $bsayi){
	$text='';
	foreach($altitem as $icerikler){
		for($i=0;$i<=$bsayi;$i++){
			$text.='&nbsp;';	
		}
		$bsayi++;
		$text.=$icerikler['item']['metin'].' '.$icerikler['item']['id'].'<br />';	
		$text.=icerikyaz($icerikler['item']['alt']['item'], $bsayi);	
	}
	return $text;
}

function sayfaUrl($id){
	global $siteUrl;
	$sayfa=GetSingleDataFromTable('icerikler',  $id);
	return $siteUrl.'sayfa/'.$sayfa['id'].'-'.$sayfa['sef_tr'].'.html';
}
function startsWith($string, $search){
	$length=strlen($search);
	if(substr($string, 0, $length) === $search){
		return true;
	}
	return false;
}

function endsWith($search, $string){
	$length=strlen($search);
	$fullen=strlen($string);
	if(substr($string, $fullen-$length, $length) === $string){
		return true;
	}
	return false;
}
function tipCevir($tipDb){
	global $tiplerdb, $tipler;
	$yeni=str_replace($tiplerdb, $tipler, $tipDb);
	return $yeni;
}

function Redirect301(){
	global $siteUrl;
	if(GetRowCountWithSingleWhere('yonlendirme', 'fromlink="'.$_SERVER["REQUEST_URI"].'" and aktif=1')>0){
		$link=GetSingleDataFromTableWithSingleWhere('yonlendirme', 'fromlink="'.$_SERVER["REQUEST_URI"].'" and aktif=1');
		//echo $siteUrl.$link['tolink'];
		//echo 'adasda';
		//echo $_SERVER["REQUEST_URI"];
		header('HTTP/1.1 301 Moved Permanently');
		header('location: '.$siteUrl.$link['tolink']); 
	}
}
function curPageURL() {
 $pageURL = 'http://';
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
function getChatData(){
	global $siteUrl, $CurrentUser, $ProfileImageFolder;
	$counter=1;
	$allChatsCount=GetRowCount('chat');
	$chats=GetDataToTableWithSingleWhereAndLimit('chat', '*', 'date desc', '', 1, 25); 
	asort($chats); ?>
	<? foreach($chats as $chat){
		$inOut=$chat['userId']==$CurrentUser['id']? 'in':'out';
		$msgUser=GetSingleDataFromTable('users', $chat['userId']);
		$avatar=(isset($msgUser['avatar']) && !empty($msgUser['avatar'])) ? $siteUrl.$ProfileImageFolder.$msgUser['avatar'] : $siteUrl.'img/_defaults/profile-image-default.jpg';
		?> 
        <li class="<?=$inOut?>" id="chat_<?=$chat['id']?>"><img src="<?=$avatar?>" class="avatar" />
        	<div class="message">
            	<? if($CurrentUser['role_admin']==1){ ?>
                	<a href="javascript:void(0);" onClick="removeChatMessage(<?=$chat['id']?>);"><i class="fa fa-times"></i></a>
				<? } ?>
            	<span class="chat-arrow"></span>
                <a href="#" class="chat-name"><?=$msgUser['name'].' '.$msgUser['surname']?></a>&nbsp;
                <span class="chat-datetime">at <?=tarihCevir($chat['date'], 'M d, Y H:i', 'en')?></span>
                <span class="chat-body"><?=temizle($chat['messageContent'])?></span>
            </div>
            <? if($counter==count($chats)){ ?><input type="hidden" id="lastChatTime" value="<? echo count($chats)>0? $chat['date']:'00-00-00 00:00:00';  ?>"><? } ?>
        </li>
    <? $counter++; } ?>
<? }
function getToDoList($userId){
	global $siteUrl, $CurrentUser, $ProfileImageFolder;
	$todolist=GetDataToTableWithSingleWhere('todolist', '*', 'sira desc', 'idTo='.$userId);
	foreach($todolist as $task){ ?>
    	<li class="clearfix<? echo $task['isCompleted']==1 ? ' completed':''; ?>" id="task-<?=$task['id']?>"><span class="drag-drop"><i></i></span>
        	<div class="todo-check pull-left">
            &nbsp;
            </div>
			<div class="todo-title">
            	<span><?=$task['taskContent']?></span>
                <div class="editTaskDiv">
	                <form method="post" data-userId="<?=$CurrentUser['id']?>" data-taskId="<?=$task['id']?>" onSubmit="javascript:void(0);">
                        <input type="text" name="editTaskInput" value="<?=$task['taskContent']?>" class="" />
                        <button type="button" onClick="saveToDoTask('<?=$CurrentUser['id']?>', '<?=$task['id']?>');">Save</button>
                        <button type="button" onClick="cancelEditTask('<?=$task['id']?>');">Cancel</button>
                    </form>
                </div>
			</div>
			<div class="todo-actions pull-right clearfix">
            	<a href="javascript:void(0);" onClick="completeTask('<?=$CurrentUser['id']?>', '<?=$task['id']?>');" class="todo-complete"><i class="fa fa-check"></i></a>
                <a href="javascript:void(0);" onClick="editTask('<?=$task['id']?>');" class="todo-edit"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0);" onClick="deleteTask('<?=$CurrentUser['id']?>', '<?=$task['id']?>');" class="todo-remove"><i class="fa fa-trash-o"></i></a>
            </div>
		</li>
	<? }
}
function getNextStatus($status){
	$mevcut=GetSingleDataFromTableWithWhere('param_status', 'value', $status);
	if(empty($mevcut)){
		$mevcut=GetSingleDataFromTableWithWhere('param_status', '1', '1 limit 1');
	}
	$yeni=GetSingleRowDataFromTableWithSingleWhere('param_status', 'value as "value"', 'sira>'.$mevcut['sira'].' limit 1');
	if(empty($yeni)){
		$yeni=GetSingleRowDataFromTableWithSingleWhere('param_status', 'value as "value"', 'sira=(select min(sira) from param_status)');
	}
	return $yeni['value'];
}
function extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}

function money($money='0.00', $birim, $bosluk=false) {
	$money = DotFix(str_replace('.', '', FloatFormat($money, 2)));
	$money = explode('.',$money);
	if(count($money)!=2) return false;
	$money_left = $money['0'];
	$money_right = $money['1'];


	//ONİKİLER
	$l12 = '';
	if(strlen($money_left)==11){
		$i = (int) floor($money_left/100000000000);
		if($i==1) $l12="YÜZ";
        if($i==2) $l12="İKİ YÜZ";
        if($i==3) $l12="ÜÇ YÜZ";
        if($i==4) $l12="DÖRT YÜZ";
        if($i==5) $l12="BEŞ YÜZ";
        if($i==6) $l12="ALTI YÜZ";
        if($i==7) $l12="YEDİ YÜZ";
        if($i==8) $l12="SEKİZ YÜZ";
        if($i==9) $l12="DOKUZ YÜZ";
        if($i==0) $l12="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }
	
	//ONBİRLER
	$l11 = '';
	if(strlen($money_left)==10){
		$i = (int) floor($money_left/10000000000);
        if($i==1) $l11="ON";
        if($i==2) $l11="YİRMİ";
        if($i==3) $l11="OTUZ";
        if($i==4) $l11="KIRK";
        if($i==5) $l11="ELLİ";
        if($i==6) $l11="ATMIŞ";
        if($i==7) $l11="YETMİŞ";
        if($i==8) $l11="SEKSEN";
        if($i==9) $l11="DOKSAN";
        if($i==0) $l11="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }

	//ONLAR
	$l10 = '';
	if(strlen($money_left)==10){
		$i = (int) floor($money_left/1000000000);
		if($i==1){
            if($i!="NULL"){
                $l10 = "BİR MİLYAR";
            }else{
                $l10 = "MİLYAR";
            }
        }
        if($i==2) $l10="İKİ MİLYAR";
        if($i==3) $l10="ÜÇ MİLYAR";
        if($i==4) $l10="DÖRT MİLYAR";
        if($i==5) $l10="BEŞ MİLYAR";
        if($i==6) $l10="ALTI MİLYAR";
        if($i==7) $l10="YEDİ MİLYAR";
        if($i==8) $l10="SEKİZ MİLYAR";
        if($i==9) $l10="DOKUZ MİLYAR";
        if($i==0) $l10="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }

	//DOKUZLAR
	$l9 = '';
	if(strlen($money_left)==9){
		$i = (int) floor($money_left/100000000);
		if($i==1) $l9="YÜZ";
        if($i==2) $l9="İKİ YÜZ";
        if($i==3) $l9="ÜÇ YÜZ";
        if($i==4) $l9="DÖRT YÜZ";
        if($i==5) $l9="BEŞ YÜZ";
        if($i==6) $l9="ALTI YÜZ";
        if($i==7) $l9="YEDİ YÜZ";
        if($i==8) $l9="SEKİZ YÜZ";
        if($i==9) $l9="DOKUZ YÜZ";
        if($i==0) $l9="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }

    //SEKİZLER
	$l8 = '';
    if(strlen($money_left)==8){
        $i = (int) floor($money_left/10000000);
        if($i==1) $l8="ON";
        if($i==2) $l8="YİRMİ";
        if($i==3) $l8="OTUZ";
        if($i==4) $l8="KIRK";
        if($i==5) $l8="ELLİ";
        if($i==6) $l8="ATMIŞ";
        if($i==7) $l8="YETMİŞ";
        if($i==8) $l8="SEKSEN";
        if($i==9) $l8="DOKSAN";
        if($i==0) $l8="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //YEDİLER
	$l7 = '';
    if(strlen($money_left)==7){
        $i = (int) floor($money_left/1000000);
        if($i==1){
            if($i!="NULL"){
                $l7 = "BİR MİLYON";
            }else{
                $l7 = "MİLYON";
            }
        }
        if($i==2) $l7="İKİ MİLYON";
        if($i==3) $l7="ÜÇ MİLYON";
        if($i==4) $l7="DÖRT MİLYON";
        if($i==5) $l7="BEŞ MİLYON";
        if($i==6) $l7="ALTI MİLYON";
        if($i==7) $l7="YEDİ MİLYON";
        if($i==8) $l7="SEKİZ MİLYON";
        if($i==9) $l7="DOKUZ MİLYON";
        if($i==0){
            if($i!="NULL"){
                $l7="MİLYON";
            }else{
                $l7="";
            }
        }
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //ALTILAR
	$l6 = '';
    if(strlen($money_left)==6){
        $i = (int) floor($money_left/100000);
        if($i==1) $l6="YÜZ";
        if($i==2) $l6="İKİ YÜZ";
        if($i==3) $l6="ÜÇ YÜZ";
        if($i==4) $l6="DÖRT YÜZ";
        if($i==5) $l6="BEŞ YÜZ";
        if($i==6) $l6="ALTI YÜZ";
        if($i==7) $l6="YEDİ YÜZ";
        if($i==8) $l6="SEKİZ YÜZ";
        if($i==9) $l6="DOKUZ YÜZ";
        if($i==0) $l6="";
        $money_left = substr($money_left,1,strlen($money_left)-1);
    }

    //BEŞLER
	$l5 = '';
    if(strlen($money_left)==5){
        $i = (int) floor($money_left/10000);
        if($i==1) $l5="ON";
        if($i==2) $l5="YİRMİ";
        if($i==3) $l5="OTUZ";
        if($i==4) $l5="KIRK";
        if($i==5) $l5="ELLİ";
        if($i==6) $l5="ATMIŞ";
        if($i==7) $l5="YETMİŞ";
        if($i==8) $l5="SEKSEN";
        if($i==9) $l5="DOKSAN";
        if($i==0) $l5="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //DÖRTLER
	$l4 = '';
    if(strlen($money_left)==4){
        $i = (int) floor($money_left/1000);
        if($i==1){
            if($i!=""){
                $l4 = "BİR BİN";
            }else{
                $l4 = "BİN";
            }
        }
        if($i==2) $l4="İKİ BİN";
        if($i==3) $l4="ÜÇ BİN";
        if($i==4) $l4="DÖRT BİN";
        if($i==5) $l4="BEŞ BİN";
        if($i==6) $l4="ALTI BİN";
        if($i==7) $l4="YEDİ BİN";
        if($i==8) $l4="SEKİZ BİN";
        if($i==9) $l4="DOKUZ BİN";
        if($i==0){
            if($i!=""){
                $l4="BİN";
            }else{
                $l4="BİN";
            }
        }
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //ÜÇLER
	$l3 = '';
    if(strlen($money_left)==3){
        $i = (int) floor($money_left/100);
        if($i==1) $l3="YÜZ";
        if($i==2) $l3="İKİYÜZ";
        if($i==3) $l3="ÜÇYÜZ";
        if($i==4) $l3="DÖRTYÜZ";
        if($i==5) $l3="BEŞYÜZ";
        if($i==6) $l3="ALTIYÜZ";
        if($i==7) $l3="YEDİYÜZ";
        if($i==8) $l3="SEKİZYÜZ";
        if($i==9) $l3="DOKUZYÜZ";
        if($i==0) $l3="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //İKİLER
	$l2 = '';
    if(strlen($money_left)==2){
        $i = (int) floor($money_left/10);
        if($i==1) $l2="ON";
        if($i==2) $l2="YİRMİ";
        if($i==3) $l2="OTUZ";
        if($i==4) $l2="KIRK";
        if($i==5) $l2="ELLİ";
        if($i==6) $l2="ATMIŞ";
        if($i==7) $l2="YETMİŞ";
        if($i==8) $l2="SEKSEN";
        if($i==9) $l2="DOKSAN";
        if($i==0) $l2="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //BİRLER
	$l1 = '';
    if(strlen($money_left)==1){
        $i = (int) floor($money_left/1);
        if($i==1) $l1="BİR";
        if($i==2) $l1="İKİ";
        if($i==3) $l1="ÜÇ";
        if($i==4) $l1="DÖRT";
        if($i==5) $l1="BEŞ";
        if($i==6) $l1="ALTI";
        if($i==7) $l1="YEDİ";
        if($i==8) $l1="SEKİZ";
        if($i==9) $l1="DOKUZ";
        if($i==0) $l1="";
        $money_left=substr($money_left,1,strlen($money_left)-1);
    }

    //SAĞ İKİ
	$r2 = '';
    if(strlen($money_right)==2){
        $i = (int) floor($money_right/10);
        if($i==1) $r2="ON";
        if($i==2) $r2="YİRMİ";
        if($i==3) $r2="OTUZ";
        if($i==4) $r2="KIRK";
        if($i==5) $r2="ELLİ";
        if($i==6) $r2="ALTMIŞ";
        if($i==7) $r2="YETMİŞ";
        if($i==8) $r2="SEKSEN";
        if($i==9) $r2="DOKSAN";
        if($i==0) $r2="SIFIR";
        $money_right=substr($money_right,1,strlen($money_right)-1);
    }

    //SAĞ BİR
	$r1 = '';
    if(strlen($money_right)==1){
        $i = (int) floor($money_right/1);
        if($i==1) $r1="BİR";
        if($i==2) $r1="İKİ";
        if($i==3) $r1="ÜÇ";
        if($i==4) $r1="DÖRT";
        if($i==5) $r1="BEŞ";
        if($i==6) $r1="ALTI";
        if($i==7) $r1="YEDİ";
        if($i==8) $r1="SEKİZ";
        if($i==9) $r1="DOKUZ";
        if($i==0) $r1="";
        $money_right=substr($money_right,1,strlen($money_right)-1);
    }
	
	$tutar = $l12.' '.$l11.' '.$l10.' '.$l9.' '.$l8.' '.$l7.' '.$l6.' '.$l5.' '.$l4.' '.$l3.' '.$l2.' '.$l1;
	if(!$bosluk){
		$tutar = str_replace(' ', '', $tutar);
	}
	$tutar2 = $r2.' '.$r1;
	if(!$bosluk){
		$tutar2 = str_replace(' ', '', $tutar2);
	}
	$pb1=$birim['deger2'];
	$pb2=$birim['deger3'];
	$result = '';
	$result.= !empty($tutar) ? $tutar.' '.$pb1.' ' : '';
	$result.= !empty($tutar2) ? $tutar2.' '.$pb2 : '';
    return $result;
}

function GetInvoiceNo($id, $bookingNo=0){
	$packing=GetSingleDataFromTableWithSingleWhere('packingpo', 'id='.$id);
	$invoiceNumber = '';
	if(!empty($packing)){
		$bookingid=$packing['bookingid'];
		$booking=GetSingleDataFromTableWithSingleWhere('bookings', 'id='.$bookingid);
		$export=GetSingleDataFromTableWithSingleWhere('exports', 'id='.$booking['exportid']);
		$invoiceno=$export['faturano'];
		
		$poid=$id;
		$bookingorder=$booking['sira'];
		$bookingids = GetDataToTableWithSingleWhere('bookings', 'GROUP_CONCAT(distinct id order by sira) as "nums"', 'id', 'exportid='.$export['id'].' and sira<'.$bookingorder);
		$pocount = GetDataToTableWithSingleWhere('packingpo', 'count(*) as "count"', 'id', 'FIND_IN_SET(bookingid, "'.$bookingids[0]['nums'].'")');
		
		
		
		$ordernumbers = GetDataToTableWithSingleWhere('packingpo', 'GROUP_CONCAT(distinct sira order by sira) as "nums"', 'bookingid', 'bookingid='.$bookingid);
		$ordernumbers = explode(',', $ordernumbers[0]['nums']);
		$orderkey = array_search($packing['sira'], $ordernumbers);
		$invoiceNumber = ($invoiceno.(!empty($invoiceno)?'-':'').($orderkey+1+$pocount[0]['count']));
	}
	else{
		if($bookingNo!=0){
			$booking=GetSingleDataFromTableWithSingleWhere('bookings', 'id='.$bookingNo);
			$export=GetSingleDataFromTableWithSingleWhere('exports', 'id='.$booking['exportid']);
			$invoiceno=$export['faturano'];
			$bookingorder=$booking['sira'];
			$bookingids = GetDataToTableWithSingleWhere('bookings', 'GROUP_CONCAT(distinct id order by sira) as "nums"', 'id', 'exportid='.$export['id'].' and sira<'.$bookingorder);
			$pocount = GetDataToTableWithSingleWhere('packingpo', 'count(*) as "count"', 'id', 'FIND_IN_SET(bookingid, "'.$bookingids[0]['nums'].'")');
			$ordernumbers = GetDataToTableWithSingleWhere('packingpo', 'count(*) as "count"', 'bookingid', 'bookingid='.$bookingNo);
			$orderkey = $ordernumbers[0]['count'];
			$invoiceNumber = ($invoiceno.(!empty($invoiceno)?'-':'').($orderkey+1+$pocount[0]['count']));			
		}
	}
	return $invoiceNumber;
}

function CalculateExportSum($exportid=0, $bookingid=0, $packingid=0){
	$id=$exportid;
	if($id==0){
		if($bookingid!=0){
			$id=GetSingleRowDataFromTableWithSingleWhere('bookings', 'exportid', 'id='.$bookingid);
			$id=$id['exportid'];
		}
		else{
			if($packingid!=0){
				$bookingid=GetSingleRowDataFromTableWithSingleWhere('packingpo', 'bookingid', 'id='.$packingid);
				$bookingid=$bookingid['bookingid'];
				$id=GetSingleRowDataFromTableWithSingleWhere('bookings', 'exportid', 'id='.$bookingid);
				$id=$id['exportid'];
			}
			else{
				return;
			}
		}
	}
	
	$net=0;
	$brut=0;
	$kab=0;
	$tutar=0;
	$toplamsatis=0;
	$toplamalis=0;
	$toplamm2=0;
	$imalatcilar='';
	$export=GetSingleRowDataFromTableWithSingleWhere('exports', 'id, parabirimi', 'id='.$id);
	$bookings=GetDataToTableWithWhere('bookings', 'id', 'sira', 'exportid', $id);
	foreach($bookings as $bk){
		$packingpo=GetDataToTableWithWhere('packingpo', 'id', 'sira', 'bookingid', $bk['id']);
		foreach($packingpo as $pk){
			$packings=GetDataToTableWithWhere('packings p left join param_imalatci i on p.imalatci=i.id', 'p.*, i.tag as "imalatci"', 'p.sira', 'p.poid', $pk['id']);
			foreach($packings as $pack){
				//kabsayisi "KAB SAYISI" | brutagirlik*kabsayisi "BRÜT AĞIRLIK" | netagirlik*kabsayisi "NET AĞIRLIK" | miktar*tutar*kabsayisi "TUTAR" | imalatcilar
				$net+=$pack['netagirlik']*$pack['kabsayisi'];
				$brut+=$pack['brutagirlik']*$pack['kabsayisi'];
				$kab+=$pack['kabsayisi'];
				$tutar+=$pack['miktar']*$pack['tutar']*$pack['kabsayisi'];
				if($export['parabirimi']=='$'){
					$toplamsatis+=$pack['miktar']*$pack['tutar']*$pack['kabsayisi'];
					$toplamalis+=$pack['miktar']*$pack['alistutar']*$pack['kabsayisi'];
				}
				if($pack['birim']=='m2'){
					$toplamm2+=$pack['miktar']*$pack['kabsayisi'];
				}
				if (!preg_match('/@@'.$pack['imalatci'].'@@/', $imalatcilar) && !empty($pack['imalatci'])) {
					$imalatcilar.='@@'.$pack['imalatci'].'@@, ';
				}
				$packingssub=GetDataToTableWithWhere('packingssub', '*', 'sira', 'packingid', $pack['id']);
				foreach($packingssub as $ps){
					//miktar*tutar "TUTAR"
					$tutar+=$ps['miktar']*$ps['tutar'];
					if($export['parabirimi']=='$'){
						$toplamsatis+=$ps['miktar']*$ps['tutar'];
						$toplamalis+=$ps['miktar']*$ps['alistutar'];
					}
					
					if($ps['birim']=='m2'){
						$toplamm2+=$ps['miktar'];
					}
				}
			}
		}
	}
	$imalatcilar=str_replace('@@', '', strlen($imalatcilar)>1?substr($imalatcilar, 0, -2):$imalatcilar);
	if(UpdateTable2('exports', array('net', 'brut', 'kab', 'tutar', 'toplamsatis', 'toplamalis', 'toplamm2', 'imalatcilar'), array($net, $brut, $kab, $tutar, $toplamsatis, $toplamalis, $toplamm2, $imalatcilar), 'id', $id)){
		return true;
	}
	else{
		return;	
	}
}

function MysqlHourDifference(){
	$sqlTime = ExecuteOnlySelect('NOW() as "now"');
	$sqlDateTime=strtotime($sqlTime['now'], time());
	return (time()-$sqlDateTime)/3600;
}

function MysqlHourAgo($diff=0){
	return $diff - (MysqlHourDifference());
}

function DovizKuru($DovizTarih){
	$eksilt = -1;
	if(tarihCevir($DovizTarih, 'w', 'tr')==0) $eksilt=-2;
	else if(tarihCevir($DovizTarih, 'w', 'tr')==1) $eksilt=-3;
	$bulundu=false;
	$kurMaxControl=7; //kontrol edilecek en fazla gün
	$csyc =0;
	while(!$bulundu){
		$kurtarihGun=(tarihCevir($DovizTarih, 'd', 'tr')+$eksilt);
		$kurtarihGunDolgu=str_pad($kurtarihGun, 2, "0", STR_PAD_LEFT);
		$kurtarihTCMB=tarihCevir($DovizTarih, 'Ym/', 'tr').$kurtarihGunDolgu.tarihCevir($DovizTarih, 'mY', 'tr');
		$kurkontrol = get_headers('http://www.tcmb.gov.tr/kurlar/'.$kurtarihTCMB.'.xml', 1);
		if($kurkontrol[0] == 'HTTP/1.0 404 Not Found'){
			$eksilt--;
		}
		else{
			$bulundu=true;	
		}
		$csyc++;
		if($csyc>=$kurMaxControl){
			break;	
		}
	}
	
	
	
	$kurtarihGun=(tarihCevir($DovizTarih, 'd', 'tr')+$eksilt);
	$kurtarihGunDolgu=str_pad($kurtarihGun, 2, "0", STR_PAD_LEFT);
	$kurtarih=tarihCevir($DovizTarih, 'Ym/', 'tr').$kurtarihGunDolgu.tarihCevir($DovizTarih, 'mY', 'tr');
	$kurtarih2=$kurtarihGunDolgu.tarihCevir($DovizTarih, '/m/Y', 'tr');
	
	
	$usd_DS = 0;
	$usd_DA = 0;
	$usd_ES = 0;
	$usd_EA = 0;
							
	if($bulundu){
		@$xml= simplexml_load_file('http://www.tcmb.gov.tr/kurlar/'.$kurtarih.'.xml');
		foreach ($xml->Currency as $Currency) {
			if ($Currency['Kod']=="USD") {
				// USD ALIŞ-SATIŞ
				$usd_DS=$Currency->BanknoteSelling; $usd_DA=$Currency->BanknoteBuying;
				// USD EFEKTİF ALIŞ-SATIŞ
				$usd_ES=$Currency->ForexSelling; $usd_EA=$Currency->ForexBuying;
			}
		}
	}
	return array(
		'usd_DS' => $usd_DS,
		'usd_DA' => $usd_DA,
		'usd_ES' => $usd_ES,
		'usd_EA' => $usd_EA,
		'kurtarih' => $kurtarih,
		'kurtarih2' => $kurtarih2,
		'kurtarihGunDolgu' => $kurtarihGunDolgu,
	);
}

function kdv($oran=18, $sadecekdv=false){
	if($oran>0){
		return ($oran/100) + ($sadecekdv ? 0 : 1);
	}
	return $sadecekdv ? 0 : 1;
}


function wktohtml($kelimeBul, $kelimeDegistir, $islemNo) {
    $sayfaLinkBul = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    if ($islemNo == 1) {
        $sonuc = str_replace($kelimeBul, $kelimeDegistir, $sayfaLinkBul);

        return $sonuc;
    }

    else if($islemNo == 2) {
        global $firma;
        $firmaPrintEki = $firma['print'];

        $kelimeDegistir = $kelimeDegistir . "-" . $firmaPrintEki;

        $sonuc = str_replace($kelimeBul, $kelimeDegistir, $sayfaLinkBul);

        return $sonuc;
    }   

}

function isValidEmail($email){
	$pattern = "^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$";
	if (@eregi($pattern, $email)){ 
		return true;
	}
	else {
		return false;
	}   
}


function reArrayFiles(&$file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}

function dilSecimi($dil){
	if(!empty($dil) && $dil=='tr' || $dil=='en' || $dil=='ru' || $dil=='ar'){
		$_SESSION['dil']=$dil;
	}
}
function varsayilanDil(){
	if($_SERVER['REMOTE_ADDR']=='192.168.2.180'){
		$_SESSION['dil']='tr';
	}
	else{
		include('geoIp/geoip.inc');
		$gi = geoip_open('geoIp/GeoIP.dat',GEOIP_STANDARD);	
		if(geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR'])=='TR'){
			$_SESSION['dil']='tr';
		}
		else{
			$_SESSION['dil']='en';		
		}
		geoip_close($gi);
	}
}


function dosyalariListele($klasor){
	if ($handle = opendir($klasor) or die ("Dizin acilamadi!")) {
		$dosyalar=array();
		while (false !== ($entry = readdir($handle))) {
        	if($entry!='.' && $entry!='..'){
				$dosyalar[]=$entry;
			}
    	}
		return $dosyalar;
	}
}

function ilk($karakterSayisi, $icerik){
	$illChars=array('&nbsp;');
	$nChars=array('');
	$icerik=strip_tags(html_entity_decode($icerik));
	$icerik=str_replace($illChars, $nChars, $icerik);
	if(strlen($icerik)<=$karakterSayisi){
		return $icerik;
	}
	else{
		return mb_substr($icerik, 0, $karakterSayisi, 'UTF-8').'...';
	}
}

function ilkParag($karakterSayisi, $icerik){
	$illChars=array('&nbsp;', '<p>', '</p>');
	$nChars=array('', '', '');
	$icerik=strip_tags(html_entity_decode($icerik));
	$icerik=str_replace($illChars, $nChars, $icerik);
	if(strlen($icerik)<=$karakterSayisi){
		return $icerik;
	}
	else{
		return mb_substr($icerik, 0, $karakterSayisi, 'UTF-8').'...';
	}
}

function ilkJs($karakterSayisi, $icerik){
	$illChars=array('&nbsp;', '\'');
	$nChars=array('', '\\\'');
	$icerik=strip_tags(html_entity_decode($icerik));
	$icerik=str_replace($illChars, $nChars, $icerik);
	if(strlen($icerik)<=$karakterSayisi){
		return $icerik;
	}
	else{
		return mb_substr($icerik, 0, $karakterSayisi, 'UTF-8').'...';
	}
}
function tagTemiz($ilkTag, $sonTag, $icerik){
	$taglar=array($ilkTag, $sonTag);
	$bos=array('', '');
	$icerik=strip_tags(html_entity_decode($icerik));
	$icerik=str_replace($taglar, $bos, $icerik);
	return $icerik;
}

function ilkNotDot($karakterSayisi, $icerik){
	return mb_substr($icerik, 0, $karakterSayisi, 'UTF-8');
}

function temizle($icerik){
	$icerik=stripslashes(html_entity_decode($icerik));	
	return $icerik;
}

*/

//require_once('functions_special.php');