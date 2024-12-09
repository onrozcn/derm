<?php

/*
Gelen Faks Listesi
http://api.bulutfon.com/v2/fax/incoming-faxes?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk

Gelen Faks Detayı
http://api.bulutfon.com/v2/fax/incoming-faxes/58903?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk

Gelen Faks İndir
http://api.bulutfon.com/v2/fax/incoming-faxes/58903/download?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk
*/

$apilink = 'http://api.bulutfon.com/v2/';
$apikey  = '5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk';

$json     = file_get_contents($apilink . 'fax/incoming-faxes?apikey=' . $apikey);
$jsondata = json_decode($json);
//$jsondata  = json_encode($json, JSON_UNESCAPED_SLASHES);


print_r($jsondata);

if (count($jsondata->data)) {
    // Open the table
    echo '<table border="1"><th>ID</th><th>Gonderen</th><th>Alici</th><th>Tarih</th><th>Incele</th>';

    // Cycle through the array
    foreach ($jsondata->data as $idx => $data) 
{        // Output a row
        echo "<tr>";
        echo "<td>$data->id</td>";
        echo "<td>$data->sender</td>";
        echo "<td>$data->receiver</td>";
        echo "<td>$data->created_at</td>";
        echo '<td>' . '<a href="' . $apilink . 'fax/incoming-faxes/' . $data->id . '/download?apikey=' . $apikey . '">Indir</a>' . '</td>';
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
}

// file_put_contents("Tmpfile.zip", fopen("http://api.bulutfon.com/v2/fax/incoming-faxes/58903/download?apikey=5K0JFEbr6Amenj2tUBCDrkrQoQ1poQNGWa1duSDro39l55if7M0HY4cwV0V2OoYD1Kk", 'r'));

