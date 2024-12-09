<?php
@$filename = $_SERVER["REQUEST_URI"];
if (preg_match("/dbStringsLocal.php/", $filename)) {
	header("Location:../");
	die();
}

$MysqlFunctions = array('NOW()');


function GenerateQuery($table, $fields, $where, $orderby)
{
	$q = 'select ' . (!empty($fields) ? $fields : '*') . ' from ' . $table;
	if (!empty($where)) {
		$q .= ' where ' . $where;
	}
	if (!empty($orderby)) {
		$q .= ' order by ' . $orderby;
	}

	return $q;
}

function GetListDataFromTable($table, $fields, $orderby, $showQuery = false)
{
	global $MysqlConnection;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysqli_query($MysqlConnection, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function GetListDataFromTableWithWhere($table, $fields, $orderby, $whereText, $where, $showQuery = false)
{
	global $MysqlConnection;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText) && $where != '')
		$query .= ' where ' . $whereText . '="' . $where . '"';
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysqli_query($MysqlConnection, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function GetListDataFromTableWithSingleWhere($table, $fields, $orderby, $whereText, $showQuery = false)
{
	global $MysqlConnection;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText))
		$query .= ' where ' . $whereText . '';
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysqli_query($MysqlConnection, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function cloudGetListDataFromTableWithSingleWhere($table, $fields, $orderby, $whereText, $showQuery = false)
{
	global $MysqlConnectionCloud;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText))
		$query .= ' where ' . $whereText . '';
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysqli_query($MysqlConnectionCloud, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function GetListDataFromTableWithSingleWhereGroupBy($table, $fields, $orderby, $groupby, $whereText, $showQuery = false)
{
	global $MysqlConnection;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText))
		$query .= ' where ' . $whereText . '';
	if (!empty($groupby))
		$query .= ' group by ' . $groupby . '';
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysqli_query($MysqlConnection, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function GetListDataFromTableWithSingleWhereAndLimit($table, $fields, $orderby, $whereText, $page, $end, $showQuery = false)
{
	global $MysqlConnection;
	$limit = ($page - 1) * $end;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText))
		$query .= ' where ' . $whereText . '';
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	$query .= ' limit ' . $limit . ', ' . $end . '';
    if ($showQuery)
        echo $query;
	$query = mysqli_query($MysqlConnection, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function GetListDataFromTableWithSingleWhereAndLimitAndRandom($table, $fields, $whereText, $page, $end)
{
	global $MysqlConnection;
	$limit = ($page - 1) * $end;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText))
		$query .= ' where ' . $whereText . '';
	$query .= ' order by rand()';
	$query .= ' limit ' . $limit . ', ' . $end . '';
	//echo $query;
	$query = mysqli_query($MysqlConnection, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

function GetSingleDataFromTable($table, $id)
{
	global $MysqlConnection;
	$qq = 'select * from ' . $table . ' where id=' . $id;
	//echo $qq;
	$query = mysqli_query($MysqlConnection, $qq);
	$data = mysqli_fetch_assoc($query);

	return $data;
}

function GetFirstDataFromTable($table)
{
	global $MysqlConnection;
	$qq = 'select * from ' . $table . ' limit 1';
	//echo $qq;
	$query = mysqli_query($MysqlConnection, $qq);
	$data = mysqli_fetch_assoc($query);

	return $data;
}

function GetSingleDataFromTableWithWhere($table, $where, $id, $showQuery = false)
{
	global $MysqlConnection;
	$q = 'select * from ' . $table . ' where ' . $where . '="' . $id . '"';
	$query = mysqli_query($MysqlConnection, $q);
	$data = mysqli_fetch_assoc($query);
    if ($showQuery)
        echo $q;

	return $data;
}

function GetSingleDataFromTableWithSingleWhere($table, $where, $showQuery = false)
{
	global $MysqlConnection;
	$q = 'select * from ' . $table . ' where ' . $where;
	$query = mysqli_query($MysqlConnection, $q);
	$data = mysqli_fetch_assoc($query);
    if ($showQuery)
        echo $q;

	return $data;
}

function GetSingleRowDataFromTableWithSingleWhere($table, $row, $where, $showQuery = false)
{
	global $MysqlConnection;
	$q = 'select ' . $row . ' from ' . $table;
	if (!empty($where)) {
		$q .= ' where ' . $where . '';
	}
	$query = mysqli_query($MysqlConnection, $q);
	$data = mysqli_fetch_assoc($query);
	if ($showQuery)
		echo $q;

	return $data;
}

function cloudGetSingleRowDataFromTableWithSingleWhere($table, $row, $where, $showQuery = false)
{
	global $MysqlConnectionCloud;
	$q = 'select ' . $row . ' from ' . $table;
	if (!empty($where)) {
		$q .= ' where ' . $where . '';
	}
	$query = mysqli_query($MysqlConnectionCloud, $q);
	$data = mysqli_fetch_assoc($query);
	if ($showQuery)
		echo $q;

	return $data;
}
/*
function cloudGetListDataFromTableWithSingleWhere($table, $fields, $orderby, $whereText, $showQuery = false)
{
	global $MysqlConnectionCloud;
	$data = array();
	$query = 'select ' . $fields . ' from ' . $table;
	if (!empty($whereText))
		$query .= ' where ' . $whereText . '';
	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysqli_query($MysqlConnectionCloud, $query);
	while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}
*/
function ExecuteOnlySelect($selects)
{
	global $MysqlConnection;
	$q = 'select ' . $selects . '';
	$query = mysqli_query($MysqlConnection, $q);
	$data = mysqli_fetch_assoc($query);

	//echo $q;
	return $data;
}

function GetIdWithUniq($table, $uniq)
{
	global $MysqlConnection;
	$query = mysqli_query($MysqlConnection, 'select id from ' . $table . ' where uniq="' . $uniq . '"');
	//echo 'select id from '.$tablo.' where uniq="'.$uniq.'"';
	$data = mysqli_fetch_assoc($query);

	return $data['id'];
}

function GetFirstOrderFromTable($table)
{
	global $MysqlConnection;
	$query = mysqli_query($MysqlConnection, 'select * from ' . $table . ' where sort_order=1');
	$data = mysqli_fetch_assoc($query);

	return $data;
}

function GetMaxIdOfTable($table, $showQuery = false)
{
    global $MysqlConnection;
    $query = mysqli_query($MysqlConnection, 'select max(id) as "max" from ' . $table);
    $data = mysqli_fetch_assoc($query);
    $max = !empty($data['max']) ? $data['max'] : 0;

    return $max;
}

function GetMaxIdDataOfFieldWithId($table, $field, $id, $showQuery = false)
{
    global $MysqlConnection;
    $q = 'select * from ' . $table . ' where ' . $field . '=' . $id . ' ORDER BY id DESC LIMIT 0, 2 ' ;
    $query = mysqli_query($MysqlConnection, $q);
    $data = mysqli_fetch_assoc($query);
    if ($showQuery)
        echo $q;

    return $data;
}

function GetMaxIdDataOfWhere($table, $where, $showQuery = false)
{
    global $MysqlConnection;
    // $q = 'select * from ' . $table . ' where ' . $field . '=' . $id . ' ORDER BY id DESC LIMIT 0, 2 ' ;
    $q = 'select * from ' . $table . ' where ' . $where . ' ORDER BY id DESC LIMIT 0, 1 ' ;
    $query = mysqli_query($MysqlConnection, $q);
    $data = mysqli_fetch_assoc($query);
    if ($showQuery)
        echo $q;

    return $data;
}

function DeleteById($table, $where, $id, $ordered, $ordername = 'sort_order')
{
	global $MysqlConnection;
	$id = MysqlSecureText($id);
	if ($ordered == true) {
		$squery = mysqli_query($MysqlConnection, 'select ' . $ordername . ' from ' . $table . ' where id=' . $id);
		$sdata = mysqli_fetch_assoc($squery);
		$ssira = $sdata[$ordername];
		$uquery = 'update ' . $table . ' set ' . $ordername . '=' . $ordername . '-1 where ' . $ordername . '>' . $ssira . '';
		//echo $uquery;
		mysqli_query($MysqlConnection, $uquery);
	}
	$dquery = 'delete from ' . $table . ' where ' . $where . '="' . $id . '"';
	//echo $dquery;
	if (mysqli_query($MysqlConnection, $dquery)) {
		return true;
	}
	else {
		return false;
	}
}

function DeleteByIdOrderWithMain($table, $where, $id, $ordered, $mainName, $ordername = 'sort_order')
{
	global $MysqlConnection;
	if ($ordered == true) {
		$squery = mysqli_query($MysqlConnection, 'select ' . $ordername . ', ' . $mainName . ' from ' . $table . ' where id=' . $id . '');
		$sdata = mysqli_fetch_assoc($squery);
		$ssira = $sdata[$ordername];
		$uquery = 'update ' . $table . ' set ' . $ordername . '=' . $ordername . '-1 where ' . $ordername . '>' . $ssira . ' and ' . $mainName . '=' . $sdata[$mainName];
		//echo $uquery;
		mysqli_query($MysqlConnection, $uquery);
	}
	$dquery = 'delete from ' . $table . ' where ' . $where . '="' . $id . '"';
	//echo $dquery;
	if (mysqli_query($MysqlConnection, $dquery)) {
		return true;
	}
	else {
		return false;
	}
}

function GetRowWithId($table, $rows, $id)
{
	global $MysqlConnection;
	$query = 'select ' . $rows . ' from ' . $table . ' where id=' . $id . '';
	$data = mysqli_fetch_assoc(mysqli_query($MysqlConnection, $query));

	return stripslashes(html_entity_decode($data[$rows]));
}

function GetRowWithWhere($table, $rows, $where)
{
	global $MysqlConnection;
	$query = 'select ' . $rows . ' from ' . $table . ' where ' . $where . '';
	$data = mysqli_fetch_assoc(mysqli_query($MysqlConnection, $query));

	return stripslashes(html_entity_decode($data[$rows]));
}

function GetRowCount($table)
{
	global $MysqlConnection;
	$query = mysqli_fetch_assoc(mysqli_query($MysqlConnection, 'select count(*) as "sayi" from ' . $table . ''));

	return $query['sayi'];
}

function GetRowCountWithWhere($table, $whereText, $where)
{
	global $MysqlConnection;
	$query = 'select count(*) as "sayi" from ' . $table;
	if (!empty($whereText) && !empty($where)) {
		$query .= ' where ' . $whereText . '="' . $where . '"';
	}
	//echo $query;
	$query = mysqli_fetch_assoc(mysqli_query($MysqlConnection, $query));

	return $query['sayi'];
}

function GetRowCountWithSingleWhere($table, $whereText, $showQuery = false)
{
	global $MysqlConnection;
	$query = 'select count(*) as "sayi" from ' . $table;
	if (!empty($whereText)) {
		$query .= ' where ' . $whereText;
	}
	if ($showQuery) echo $query;
	$query = mysqli_fetch_assoc(mysqli_query($MysqlConnection, $query));

	return $query['sayi'];
}

function GetRowSumsWithSingleWhere($tablo, $sumValue, $whereText)
{
	global $MysqlConnection;
	$query = 'select sum(' . $sumValue . ') as "sayi" from ' . $tablo . '';
	if (!empty($whereText)) {
		$query .= ' where ' . $whereText;
	}
	//echo $query;
	$query = mysqli_fetch_assoc(mysqli_query($MysqlConnection, $query));

	return $query['sayi'];
}

function AddToTable($tablo, $alanlar, $veriler, $sira, $showQuery = false)
{
	global $MysqlFunctions, $MysqlConnection;
	$asayac = 0;
	$averi = '';
	foreach ($alanlar as $alan) {
		$averi .= '`' . $alan . '`';
		if (count($alanlar) - 1 > $asayac) {
			$averi .= ', ';
		}
		$asayac++;
	}
	$vsayac = 0;
	$vveri = '';
	foreach ($veriler as $veri) {
		if (in_array($veri, $MysqlFunctions)) {
			$vveri .= '' . MysqlSecureText($veri) . '';
		}
		else {
			$vveri .= '"' . MysqlSecureText($veri) . '"';
		}
		if (count($veriler) - 1 > $vsayac) {
			$vveri .= ', ';
		}
		$vsayac++;
	}

	if ($sira == true) {
		$q = mysqli_query($MysqlConnection, 'select max(sort_order) from ' . $tablo);
		$d = mysqli_fetch_assoc($q);
		$st = ', sort_order';
		$s = $d['max(sort_order)'] + 1;
		$s = ', ' . $s;
	}
	else {
		$st = '';
		$s = '';
	}
	$query = 'insert into ' . $tablo . ' (' . $averi . $st . ') values(' . $vveri . $s . ')';
	//echo $tablo.'<br />'.$alanlar.'<br />'.$veriler.'<br />';
	//echo $query;
	if ($showQuery) echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}
}

function AddToTableWithMainOrder($tablo, $alanlar, $veriler, $mainName, $mainId)
{
	global $MysqlConnection;
	$asayac = 0;
	$averi = '';
	foreach ($alanlar as $alan) {
		$averi .= '`' . $alan . '`';
		if (count($alanlar) - 1 > $asayac) {
			$averi .= ', ';
		}
		$asayac++;
	}
	$vsayac = 0;
	$vveri = '';
	foreach ($veriler as $veri) {
		$vveri .= '"' . MysqlSecureText($veri) . '"';
		if (count($veriler) - 1 > $vsayac) {
			$vveri .= ', ';
		}
		$vsayac++;
	}

	$q = mysqli_query($MysqlConnection, 'select max(sort_order) from ' . $tablo . ' where ' . $mainName . '=' . $mainId);
	$d = mysqli_fetch_assoc($q);
	$st = ', sort_order';
	$s = $d['max(sort_order)'] + 1;
	$s = ', ' . $s;

	$query = 'insert into ' . $tablo . ' (' . $averi . $st . ') values(' . $vveri . $s . ')';
	//echo $tablo.'<br />'.$alanlar.'<br />'.$veriler.'<br />';
	//echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}
}

function AddFromAnotherTable($sourceTable, $targetTable, $sourceId, $alanlar, $sira, $showQuery = false)
{
	global $MysqlConnection;
	$asayac = 0;
	$averi = '';
	foreach ($alanlar as $alan) {
		$averi .= '`' . $alan . '`';
		if (count($alanlar) - 1 > $asayac) {
			$averi .= ', ';
		}
		$asayac++;
	}
	if ($sira) {
		//echo 'select max(sort_order) from '.$targetTable;
		$q = mysqli_query($MysqlConnection, 'select max(sort_order) from ' . $targetTable);
		$d = mysqli_fetch_assoc($q);
		$s = $d['max(sort_order)'] + 1;
		$s = ', ' . $s . ' as "sort_order"';
	}
	$query = 'insert into ' . $targetTable . ' (' . $averi . ($sira ? ', `sort_order`' : '') . ') select ' . $averi . ($sira ? $s : '') . ' from ' . $sourceTable . ' where id=' . $sourceId;
	//echo $tablo.'<br />'.$alanlar.'<br />'.$veriler.'<br />';
	if ($showQuery) {
		echo $query;
	}
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}
}

function UpdateTable($tablo, $alanlar, $veriler, $where, $wheredata, $showQuery = false)
{
	global $MysqlConnection;
	$veri = '';
	$sayac = 0;
	foreach ($alanlar as $alan) {
		$veri .= $alan . '="' . MysqlSecureText($veriler[$sayac]) . '"';
		if (count($veriler) - 1 > $sayac) {
			$veri .= ', ';
		}
		$sayac++;
	}
	$query = 'update ' . $tablo . ' set ' . $veri . ' where ' . $where . '=' . $wheredata . '';
	/*echo count($veriler);
	echo $query;*/
	if ($showQuery) echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}

}

function UpdateTable2($tablo, $alanlar, $veriler, $where, $wheredata, $showQuery = false)
{
	global $MysqlFunctions, $MysqlConnection;
	$veri = '';
	$sayac = 0;
	foreach ($alanlar as $alan) {
		if (in_array($veriler[$sayac], $MysqlFunctions)) {
			$veri .= $alan . '=' . MysqlSecureText($veriler[$sayac]) . '';
		}
		else {
			$veri .= $alan . '="' . MysqlSecureText($veriler[$sayac]) . '"';
		}
		if (count($veriler) - 1 > $sayac) {
			$veri .= ', ';
		}
		$sayac++;
	}
	$query = 'update ' . $tablo . ' set ' . $veri . ' where ' . $where . '="' . $wheredata . '"';
	/*echo count($veriler);
	echo $query;*/
	if ($showQuery) echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}

}


function UpdateTable2WithSingleWhere($tablo, $alanlar, $veriler, $where, $showQuery = false)
{
	global $MysqlConnection;
	$veri = '';
	$sayac = 0;
	foreach ($alanlar as $alan) {
		$veri .= $alan . '="' . MysqlSecureText($veriler[$sayac]) . '"';
		if (count($veriler) - 1 > $sayac) {
			$veri .= ', ';
		}
		$sayac++;
	}
	$query = 'update ' . $tablo . ' set ' . $veri . ' where ' . $where . '';
	/*echo count($veriler);
	echo $query;*/

	if ($showQuery) echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}

}

function UpdateTable2WithSingleWhere2($tablo, $alanlar, $veriler, $where, $showQuery = false)
{
	global $MysqlConnection;
	$veri = '';
	$sayac = 0;
	foreach ($alanlar as $alan) {
		$veri .= $alan . '="' . MysqlSecureText2($veriler[$sayac]) . '"';
		if (count($veriler) - 1 > $sayac) {
			$veri .= ', ';
		}
		$sayac++;
	}
	$query = 'update ' . $tablo . ' set ' . $veri . ' where ' . $where . '';
	/*echo count($veriler);
	echo $query;*/

	if ($showQuery) echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}

}

function UpdateTable3($tablo, $alanlar, $veriler, $where, $wheredata, $showQuery = false)
{
	global $MysqlConnection;
	$veri = '';
	$sayac = 0;
	foreach ($alanlar as $alan) {
		$veri .= $alan . '=' . MysqlSecureText($veriler[$sayac]) . '';
		if (count($veriler) - 1 > $sayac) {
			$veri .= ', ';
		}
		$sayac++;
	}
	$query = 'update ' . $tablo . ' set ' . $veri . ' where ' . $where . '=' . $wheredata . '';
	/*echo count($veriler);
	echo $query;*/

	if ($showQuery) echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}

}

function UpdateTable3WithSingleWhere($tablo, $alanlar, $veriler, $where)
{
	global $MysqlConnection;
	$veri = '';
	$sayac = 0;
	foreach ($alanlar as $alan) {
		$veri .= $alan . '=' . MysqlSecureText($veriler[$sayac]) . '';
		if (count($veriler) - 1 > $sayac) {
			$veri .= ', ';
		}
		$sayac++;
	}
	$query = 'update ' . $tablo . ' set ' . $veri . ' where ' . $where . '';
	/*echo count($veriler);
	echo $query;*/

	//echo $query;
	if (mysqli_query($MysqlConnection, $query)) {
		return true;
	}
	else {
		return false;
	}

}

function SortOrderUp($tablo, $id)
{
	global $MysqlConnection;
	$query = mysqli_query($MysqlConnection, 'select sort_order from ' . $tablo . ' where id=' . $id);
	$data = mysqli_fetch_assoc($query);
	$sira = $data['sort_order'];
	$sn1 = $sira - 1;
	$sp1 = $sira + 1;
	$query1 = 'update ' . $tablo . ' set sort_order=' . $sira . ' where sort_order=' . $sn1;
	$query2 = 'update ' . $tablo . ' set sort_order=' . $sn1 . ' where id=' . $id;
	/*echo $sira.'<br />';
	echo $query1 .'<br />'.$query2;*/
	if ($sira == 1) {
		return false;
	}
	else {
		if (mysqli_query($MysqlConnection, $query1) && mysqli_query($MysqlConnection, $query2)) {
			return true;
		}
		else {
			return false;
		}
	}
}

function SortOrderDown($tablo, $id)
{
	global $MysqlConnection;
	$query = mysqli_query($MysqlConnection, 'select sort_order from ' . $tablo . ' where id=' . $id);
	$mquery = mysqli_query($MysqlConnection, 'select max(sort_order) from ' . $tablo);
	$data = mysqli_fetch_assoc($query);
	$mdata = mysqli_fetch_assoc($mquery);
	$sira = $data['sort_order'];
	$msira = $mdata['max(sort_order)'];
	$sn1 = $sira - 1;
	$sp1 = $sira + 1;
	$query1 = 'update ' . $tablo . ' set sort_order=' . $sira . ' where sort_order=' . $sp1;
	$query2 = 'update ' . $tablo . ' set sort_order=' . $sp1 . ' where id=' . $id;
	/*echo $sira.'<br />'.$msira.'<br />';
	echo $query1 .'<br />'.$query2;*/
	if ($sira == $msira) {
		return false;
	}
	else {
		if (mysqli_query($MysqlConnection, $query1) && mysqli_query($MysqlConnection, $query2)) {
			return true;
		}
		else {
			return false;
		}
	}
}

function SortOrderUp2($tablo, $field, $id)
{

	global $MysqlConnection;
	$query = mysqli_query($MysqlConnection, 'select * from ' . $tablo . ' where id=' . $id);
	$data = mysqli_fetch_assoc($query);

	$oncekiquery = mysqli_query($MysqlConnection, 'select max(sort_order) as "maxsira" from ' . $tablo . ' where sort_order<' . $data['sort_order'] . ' and ' . $field . '=' . $data[$field]);
	$oncekidata = mysqli_fetch_assoc($oncekiquery);


	$sira = $data['sort_order'];
	$sn1 = $oncekidata['maxsira'];
	$sp1 = $sn1 + 1;
	$query1 = 'update ' . $tablo . ' set sort_order=' . $sp1 . ' where sort_order=' . $sn1 . ' and ' . $field . '=' . $data[$field];
	$query2 = 'update ' . $tablo . ' set sort_order=' . $sn1 . ' where id=' . $id;
	/*echo $sira.'<br />';
	echo $query1 .'<br />'.$query2;*/
	if ($sira == 1) {
		return false;
	}
	else {
		if (mysqli_query($MysqlConnection, $query1) && mysqli_query($MysqlConnection, $query2)) {
			return true;
		}
		else {
			return false;
		}
	}
}

function SortOrderDown2($tablo, $field, $id)
{
	global $MysqlConnection;
	$query = mysqli_query($MysqlConnection, 'select * from ' . $tablo . ' where id=' . $id);
	$data = mysqli_fetch_assoc($query);

	$sonrakiquery = mysqli_query($MysqlConnection, 'select ifnull(min(sort_order),0) as "minsira" from ' . $tablo . ' where sort_order>' . $data['sort_order'] . ' and ' . $field . '=' . $data[$field]);
	$sonrakidata = mysqli_fetch_assoc($sonrakiquery);

	$mquery = mysqli_query($MysqlConnection, 'select max(sort_order) from ' . $tablo . ' where ' . $field . '=' . $data[$field]);
	$mdata = mysqli_fetch_assoc($mquery);
	$msira = $mdata['max(sort_order)'];

	$sira = $data['sort_order'];
	$sn1 = $sira - 1;
	$sp1 = $sonrakidata['minsira'];
	$query1 = 'update ' . $tablo . ' set sort_order=' . $sira . ' where sort_order=' . $sp1 . ' and ' . $field . '=' . $data[$field];
	$query2 = 'update ' . $tablo . ' set sort_order=' . $sp1 . ' where id=' . $id;
	/*echo $sira.'<br />'.$msira.'<br />';
	echo $query1 .'<br />'.$query2;*/
	if ($sira == $msira) {
		return false;
	}
	else {
		if (mysqli_query($MysqlConnection, $query1) && mysqli_query($MysqlConnection, $query2)) {
			return true;
		}
		else {
			return false;
		}
	}
}




function GetDataToTable($tablo, $alanlar, $orderby, $showQuery = false)
{
	$data = array();
	$query = 'select ' . $alanlar . ' from ' . $tablo;

	if (!empty($orderby))
		$query .= ' order by ' . $orderby . '';
	if ($showQuery)
		echo $query;
	$query = mysql_query($query);
	while ($alan = mysql_fetch_array($query, MYSQL_BOTH)) {
		$alan = array_map('stripslashes', $alan);
		$data[] = $alan;
	}

	return $data;
}

/* onur ekledi*/

function GetLastIdData($table, $column='id')
{
    global $MysqlConnection;
    $q = 'select ' . $column . ' from ' . $table . ' order by id desc limit 1';
    $query = mysqli_query($MysqlConnection, $q);
    $data = mysqli_fetch_assoc($query);
    $return = $data[$column];

    return $return;
}


function GetDataToTableWithSingleWhere($tablo, $alanlar, $orderby, $whereText, $showQuery = false)
{
    global $MysqlConnection;
    $data = array();
    $query = 'select ' . $alanlar . ' from ' . $tablo;
    if (!empty($whereText))
        $query .= ' where ' . $whereText . '';
    if (!empty($orderby))
        $query .= ' order by ' . $orderby . '';
    if ($showQuery)
        echo $query;
    $query = mysqli_query($MysqlConnection, $query);
    while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
        $alan = array_map('stripslashes', $alan);
        $data[] = $alan;
    }

    return $data;
}

function GetManuelQuery($query, $showQuery = false)
{
    global $MysqlConnection;
    $data = array();
    if ($showQuery)
        echo $query;
    $query = mysqli_query($MysqlConnection, $query);
    while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
        $alan = array_map('stripslashes', $alan);
        $data[] = $alan;
    }
    return $data;
}



//function GetListDataFromTable($table, $fields, $orderby, $showQuery = false)
//{
//    global $MysqlConnection;
//    $data = array();
//    $query = 'select ' . $fields . ' from ' . $table;
//    if (!empty($orderby))
//        $query .= ' order by ' . $orderby . '';
//    if ($showQuery)
//        echo $query;
//    $query = mysqli_query($MysqlConnection, $query);
//    while ($alan = mysqli_fetch_array($query, MYSQLI_BOTH)) {
//        $alan = array_map('stripslashes', $alan);
//        $data[] = $alan;
//    }
//
//    return $data;
//}