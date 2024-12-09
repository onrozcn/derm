<?php
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

$json     = file_get_contents($apilink . 'pbx/extensions?apikey=' . $apikey);
$jsondata = json_decode($json);
//$jsondata  = json_encode($json, JSON_UNESCAPED_SLASHES);


print_r($jsondata);

if (count($jsondata->data)) {
    // Open the table
    echo '<table border="1"><th>ID</th><th>DID ID</th><th>Dahili</th><th>Ad</th><th>Statu</th><th>E-Mail</th><th>Telefon</th>';

    // Cycle through the array
    foreach ($jsondata->data as $idx => $data) {
        // Output a row
        echo "<tr>";
        echo "<td>$data->id</td>";
        echo "<td>$data->did_id</td>";
        echo "<td>$data->number</td>";
        echo "<td>$data->caller_name</td>";
        echo "<td>$data->register</td>";
        echo "<td>$data->email</td>";
        echo "<td>$data->phone</td>";
        
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
}











?>
