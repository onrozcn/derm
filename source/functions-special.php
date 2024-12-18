<?php
@$filename = $_SERVER["REQUEST_URI"];
//if (preg_match("/functions-special.php/", $filename)) {
//    header("Location:../");
//    die();
//}


/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// DERM FONKSIYONLAR //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
function paginationNew($type, $page, $orderBy, $totalDataCount, $tableItemCount, $showPage, $funcName, $all, $allButton = false)
{
    $pageCount = $totalDataCount > $tableItemCount ? ((($totalDataCount - ($totalDataCount % $tableItemCount)) / $tableItemCount) + ($totalDataCount % $tableItemCount > 0 ? 1 : 0)) : 1;
    $pagerContainer = ' col-lg-7 d-flex justify-content-lg-start justify-content-center';
    $pagerInfoContainer = $all || $pageCount > 1 ? ' d-none d-lg-block col-lg-5 text-right' : ' d-none d-lg-block col-lg-12 text-right';

    $pagerItemStart = ($page * $tableItemCount) - $tableItemCount + 1;
    $pagerItemEnd = ($page * $tableItemCount) >= $totalDataCount ? $totalDataCount : ($page * $tableItemCount);

    ?>
    <div class="row mb-3">
        <?php if ($all) { ?>
            <div class="<?php echo $pagerContainer ?>">
                <nav>
                    <ul class="pagination pagination-sm" style="margin-top: 0; margin-bottom: 0;">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="<?=$funcName?>('<?=$type?>', 1, <?=$orderBy?>);">
                                <i class="fal fa-fw fa-copy"></i> Sayfalar
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php } else if ($pageCount > 1) { ?>
            <div class="<?php echo $pagerContainer ?>">
                <nav class="mr-3">
                    <ul class="pagination pagination-sm" style="margin-top: 0; margin-bottom: 0;">
                        <li class="page-item<?php echo $page == 1 ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);" onclick="<?=$funcName?>('<?=$type?>', 1, <?=$orderBy?>);">
                                <i class="fal fa-chevron-double-left"></i>
                                <span class="d-none d-xl-inline"> İlk</span></a>
                        </li>
                        <li class="page-item<?php echo $page == 1 ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);" onclick="<?=$funcName?>('<?=$type?>', <?=$page - 1?>, <?=$orderBy?>);">
                                <i class="fal fa-chevron-left"></i>
                                <span class="d-none d-xl-inline"> Önceki</span>
                            </a>
                        </li>
                        <?php
                        //4
                        $pageCenterVal = intval($showPage / 2) + 1;

                        if ($page <= $pageCenterVal) {
                            $pageEnd = $pageCount <= $showPage ? $pageCount : $showPage;
                        } else {
                            $pageEnd = $pageCount <= ($page + $pageCenterVal - 1) ? $pageCount : ($page + $pageCenterVal - 1);
                        }

                        if ($page <= $pageCenterVal) {
                            $pageStart = 1;
                        } else if ($page <= ($pageCount - $pageCenterVal)) {
                            $pageStart = $page - $pageCenterVal + 1;
                        } else {
                            $pageStart = $pageCount <= $showPage ? 1 : $pageCount - $showPage + 1;
                        }
                        for ($p = $pageStart; $p <= $pageEnd; $p++) { ?>
                            <li class="page-item<?php echo $page == $p ? ' active' : ''; ?>">
                                <a class="page-link" href="javascript:void(0);" onclick="<?=$funcName?>('<?=$type?>', <?=$p?>, <?=$orderBy?>);"><?=$p?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item<?php echo $page == $pageCount ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);"
                               onclick="<?=$funcName?>('<?=$type?>', <?=$page + 1?>, <?=$orderBy?>);">
                                <span class="d-none d-xl-inline">Sonraki </span>
                                <i class="fal fa-chevron-right"></i>
                            </a>
                        </li>
                        <li class="page-item<?php echo $page == $pageCount ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);" onclick="<?=$funcName?>('<?=$type?>', <?=$pageCount?>, <?=$orderBy?>);">
                                <span class="d-none d-xl-inline">Son </span>
                                <i class="fal fa-chevron-double-right"></i>(<?=$pageCount?>)
                            </a>
                        </li>
                    </ul>
                </nav>

                <nav>
                    <ul class="pagination pagination-sm" style="margin-top: 0; margin-bottom: 0;">
                        <?php if ($allButton) { ?>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="<?=$funcName?>('<?=$type?>', 0, <?=$orderBy?>);">
                                    <i class="fal fa-align-justify"></i>
                                    <span class="d-none d-xl-inline"> Tümü</span>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>
            </div>
            <?php
        } ?>
        <div class="<?=$pagerInfoContainer?>">
            <small><?php echo 'Toplam ' . $totalDataCount . ' kayıttan ' . $pagerItemStart . '-' . $pagerItemEnd . ' arasındaki ' . $tableItemCount . ' kayıt gösteriliyor.'; ?></small>
        </div>
    </div>
    <?php
}
function pagination($page, $totalDataCount, $tableItemCount, $showPage, $funcName, $all, $allButton = false)
{
    $pageCount = $totalDataCount > $tableItemCount ? ((($totalDataCount - ($totalDataCount % $tableItemCount)) / $tableItemCount) + ($totalDataCount % $tableItemCount > 0 ? 1 : 0)) : 1;
    $pagerContainer = ' col-lg-7 d-flex justify-content-lg-start justify-content-center';
    $pagerInfoContainer = $all || $pageCount > 1 ? ' d-none d-lg-block col-lg-5 text-right' : ' d-none d-lg-block col-lg-12 text-right';

    $pagerItemStart = ($page * $tableItemCount) - $tableItemCount + 1;
    $pagerItemEnd = ($page * $tableItemCount) >= $totalDataCount ? $totalDataCount : ($page * $tableItemCount);

    ?>
    <div class="row mb-3">
        <?php if ($all) { ?>
            <div class="<?php echo $pagerContainer ?>">
                <nav>
                    <ul class="pagination pagination-sm" style="margin-top: 0; margin-bottom: 0;">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="<?php echo $funcName ?>(1);"><i
                                        class="fal fa-fw fa-copy"></i> Sayfalar</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php } else if ($pageCount > 1) { ?>
            <div class="<?php echo $pagerContainer ?>">
                <nav class="mr-3">
                    <ul class="pagination pagination-sm" style="margin-top: 0; margin-bottom: 0;">
                        <li class="page-item<?php echo $page == 1 ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);" onclick="<?php echo $funcName ?>(1);"><i
                                        class="fal fa-chevron-double-left"></i><span
                                        class="d-none d-xl-inline"> İlk</span></a>
                        </li>
                        <li class="page-item<?php echo $page == 1 ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);"
                               onclick="<?php echo $funcName ?>(<?php echo $page - 1 ?>);"><i
                                        class="fal fa-chevron-left"></i><span class="d-none d-xl-inline"> Önceki</span></a>
                        </li>
                        <?php
                        //4
                        $pageCenterVal = intval($showPage / 2) + 1;

                        if ($page <= $pageCenterVal) {
                            $pageEnd = $pageCount <= $showPage ? $pageCount : $showPage;
                        } else {
                            $pageEnd = $pageCount <= ($page + $pageCenterVal - 1) ? $pageCount : ($page + $pageCenterVal - 1);
                        }

                        if ($page <= $pageCenterVal) {
                            $pageStart = 1;
                        } else if ($page <= ($pageCount - $pageCenterVal)) {
                            $pageStart = $page - $pageCenterVal + 1;
                        } else {
                            $pageStart = $pageCount <= $showPage ? 1 : $pageCount - $showPage + 1;
                        }
                        for ($p = $pageStart; $p <= $pageEnd; $p++) { ?>
                            <li class="page-item<?php echo $page == $p ? ' active' : ''; ?>">
                                <a class="page-link" href="javascript:void(0);"
                                   onclick="<?php echo $funcName ?>(<?php echo $p ?>);"><?php echo $p ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item<?php echo $page == $pageCount ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);"
                               onclick="<?php echo $funcName ?>(<?php echo $page + 1; ?>);"><span
                                        class="d-none d-xl-inline">Sonraki </span><i
                                        class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item<?php echo $page == $pageCount ? ' disabled' : ''; ?>">
                            <a class="page-link" href="javascript:void(0);"
                               onclick="<?php echo $funcName ?>(<?php echo $pageCount; ?>);"><span
                                        class="d-none d-xl-inline">Son </span><i
                                        class="fal fa-chevron-double-right"></i>(<?php echo $pageCount ?>)</a>
                        </li>
                    </ul>
                </nav>

                <nav>
                    <ul class="pagination pagination-sm" style="margin-top: 0; margin-bottom: 0;">
                        <?php if ($allButton) { ?>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="<?php echo $funcName ?>(1, 0);"><i
                                            class="fal fa-align-justify"></i><span
                                            class="d-none d-xl-inline"> Tümü</span></a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>
            </div>
            <?php
        } ?>
        <div class="<?php echo $pagerInfoContainer ?>">
            <small><?php echo 'Toplam ' . $totalDataCount . ' kayıttan ' . $pagerItemStart . '-' . $pagerItemEnd . ' arasındaki ' . $tableItemCount . ' kayıt gösteriliyor.'; ?></small>
            <select class="kt-hidden form-control-sm" onchange="<?php echo $funcName ?>(1);">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    </div>
    <?php
}

function UserListByPermission($permission, $onlyActive = true)
{
    global $CurrentFirm;

    $where = '(u.permissions LIKE "%&quot;' . $permission . '&quot;%" OR (p.permissions LIKE "%&quot;' . $permission . '&quot;%" AND p.firm_id=' . $CurrentFirm['id'] . '))';

    if ($onlyActive) {
        $where .= ' AND u.active=1';
    }

    return GetListDataFromTableWithSingleWhere("users u left join users_permissions p on (u.id=p.user_id)", "u.*", "u.id", $where, false);
}

function checkPermission($perms)
{
    global $CurrentUser;

    $equal = 0;
    foreach ($perms as $e) {
        if (
            (isset($CurrentUser['permission'][$e]) && $CurrentUser['permission'][$e] == 1)
            || (isset($CurrentUser['permissionOfFirm'][$CurrentUser['selectedFirm']][$e]) && $CurrentUser['permissionOfFirm'][$CurrentUser['selectedFirm']][$e] == 1)
        ) {
            $equal += 1;
        }
    }

    return $equal > 0;
}

function checkPermissionPage($perms)
{
    global $siteUrl;

    if (!checkPermission($perms)) {
        header('location:' . $siteUrl);
        die();
    }
}

function dateTimeRangeDateExplode($data)
{
    $tarih = explode('/', $data);
    return $tarih;
}

function sameSizeCharacter($string, $value = 7)
{
    // echo $string;
    $count = strlen(utf8_decode($string));
    //$count = strlen($string);
    $ekle  = '';
    if ($count < $value) {
        $fark = $value - $count;
        for ($i = 1; $i <= $fark; $i++) {
            $ekle .= '&nbsp;';
        }
    }
    $cikti = $string . $ekle;
    return $cikti;
}


function TelegramSendMessage ($token, $chatId, $type, $message, $photo ='') {
    // TelegramSendMessage($setting['telegram_token'], $CurrentUser['telegram_chatid'], 'sendPhoto', 'foto caption aciklama burada', new CURLFile('C:\wamp64\www\projects\derm\assets\img\avatar\default.jpg'));
    // TelegramSendMessage($setting['telegram_token'], $CurrentUser['telegram_chatid'], 'sendMessage', 'mesajim burada');

    if ($type == 'sendMessage') {
        $post_fields = array(
            'chat_id' => $chatId,
            'text' => $message,
        );
    } elseif ($type == 'sendPhoto') {
        $post_fields = array(
            'chat_id'   => $chatId,
            'caption' => $message,
            'photo'     => $photo
        );
    }
    $url = 'https://api.telegram.org/bot' . $token . '/' . $type;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function CalculateTimeDifference($dateTimeStart, $dateTimeEnd) {
    if ( isset($dateTimeStart) && isset($dateTimeEnd) && Html5DateTimeLocalDecode($dateTimeStart) != '0000-00-00 00:00:00' && Html5DateTimeLocalDecode($dateTimeEnd) != '0000-00-00 00:00:00' ) {
        $resultMinutes =  round(abs(strtotime($dateTimeStart) - strtotime($dateTimeEnd)) / 60,2);
            return sprintf('%02d',$resultMinutes/60|0) .':'. ( sprintf('%02d',$resultMinutes % 60));
            // return sprintf('%02d',intdiv($resultMinutes, 60)) .':'. ( sprintf('%02d',$resultMinutes % 60)); PHP 8 uyumlu
    }
}

function CalculateAbsDifference($data1, $data2) {
    if (isset($data1) && isset($data2)) {
        return round(abs($data1 - $data2));
    }
}

function Html5DateTimeLocalDecode($datetime){
    return str_replace(array('T'),array(' '),$datetime);
}

function Html5DateTimeLocalEncode($datetime){
    return str_replace(array(' '),array('T'),$datetime);
}

function CmToM3($en, $boy, $yukseklik, $format = 'tr') {
    if (isset($en) && isset($boy) && isset($yukseklik) && $en!=0 && $boy!=0 && $yukseklik!=0) {
        if ($format == 'tr') {
            return FloatFormat($en * $boy * $yukseklik / 1000000, 2);
        } else if ($format == 'en') {
            return round($en * $boy * $yukseklik / 1000000, 2);
        }
    } else {
        return '';
    }
}

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function AddLogToTxt($fileName, $line, $maxLine = 50) {
    // Remove Empty Spaces
    $file = array_filter(array_map("trim", file($fileName)));

    // Make Sure you always have maximum number of lines
    $file = array_slice($file, 0, $maxLine);

    // Remove any extra line
    count($file) >= $maxLine and array_shift($file);

    // Add new Line
    array_push($file, $line);

    // Save Result
    file_put_contents($fileName, implode(PHP_EOL, array_filter($file)));
}