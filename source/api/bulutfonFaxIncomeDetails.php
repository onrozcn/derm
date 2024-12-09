<?php
$id = $_GET['id'];
/*
Gelen Faks Listes
ihttp://api.bulutfon.com/v2/fax/incoming-faxes?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk

Gelen Faks Detayı
http://api.bulutfon.com/v2/fax/incoming-faxes/58903?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk

Gelen Faks İndir
http://api.bulutfon.com/v2/fax/incoming-faxes/58903/download?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk
*/

$apilink = 'http://api.bulutfon.com/v2/';
$apikey  = '5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk';

$json     = file_get_contents($apilink . 'fax/incoming-faxes/' . $id . '?apikey=' . $apikey);
$jsondata = json_decode($json, true);
//$jsondata  = json_encode($json, JSON_UNESCAPED_SLASHES);


print_r($jsondata);




echo '<br><br><br><br>';




echo $jsondata['attachment'];


echo '<br><br><br><br><a href="' . $jsondata['attachment'] . '">INDIR</a>';




echo '<br><br><br><br>';











?>
