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

$json     = file_get_contents($apilink . 'cdr/list?apikey=' . $apikey .'&limit=10000&');
$jsondata = json_decode($json);
//$jsondata  = json_encode($json, JSON_UNESCAPED_SLASHES);


//print_r($jsondata);

if (count($jsondata->data)) {
    // Open the table
    echo '<table border="1"><th>#</th><th>Tip</th><th>Arayan</th><th>Aranan</th><th>Sure</th><th>Dahili</th><th>Tarih</th><th>Record</th>';

    // Cycle through the array
    $say = 0;
    foreach ($jsondata->data as $idx => $data) {
        $say++;
        // Output a row
        echo "<tr>";

        echo "<td>$say</td>";
        echo "<td>$data->direction</td>";
        echo "<td>$data->caller</td>";
        echo "<td>$data->callee</td>";
        echo "<td>$data->duration</td>";
        echo "<td>$data->caller_extension</td>";
        echo "<td>$data->call_time</td>";
        echo "<td>$data->call_record</td>";
        
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
}











?>
