<?php
require_once('../source/settings.php');
require_once('../source/parameters.php');
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
if ($action == 'ParameterList') {
	ParameterList(MysqlSecureText($_POST['cat']), MysqlSecureText($_POST['parameter']), MysqlSecureText($_POST['mode']));
}
else if ($action == 'LoadParameterData') {
	LoadParameterData(MysqlSecureText($_POST['cat']), MysqlSecureText($_POST['parameter']), MysqlSecureText($_POST['id']));
}
else if ($action == 'ParameterForm') {
	ParameterForm($_POST);
}
else if ($action == 'SwitchModeParameter') {
    SwitchModeParameter(MysqlSecureText($_POST['cat']), MysqlSecureText($_POST['parameter']), MysqlSecureText($_POST['id']), MysqlSecureText($_POST['currentmode']));
}
else if ($action == 'DeleteParameter') {
	DeleteParameter(MysqlSecureText($_POST['cat']), MysqlSecureText($_POST['parameter']), MysqlSecureText($_POST['id']));
}
else if ($action == 'ParameterOrderChange') {
	ParameterOrderChange(MysqlSecureText($_POST['id']), MysqlSecureText($_POST['cat']), MysqlSecureText($_POST['parameter']), MysqlSecureText($_POST['direction']));
}

function ParameterList($cat, $type, $mode)
{
	global $parameters, $CurrentFirm;
	if (empty($type)) {
		echo 'Parameter type not found';
	}
	else {
		$parameter = $parameters[$cat]['categoryFields'][$type];

		$fromText = 'param_' . $cat . '_' . $type . ' p';
		$selectText = 'p.*';

		$counterNumber = 1;

		foreach ($parameter['fields'] as $f) {
			if ($f['type'] == 'parameter') {
				$fromText .= ' left join ' . $f['parameter'] . ' p' . $counterNumber . ' on (p.' . $f['name'] . '= p' . $counterNumber . '.id)';
				$selectText .= ', p' . $counterNumber . '.' . $f['param_field'] . ' as "' . $f['parameter'] . '_' . $f['param_field'] . '"';
				$counterNumber++;
			}
		}

		$firmWherePostFix = $parameter['isCommon'] ? '' : ' and p.sirket_id=' . $CurrentFirm['id'];
		if ($mode=='active') {
		    $parameterlist = GetListDataFromTableWithSingleWhere($fromText, $selectText, $parameter['orderby'], '1=1 and p.active=1 ' . $firmWherePostFix, false);
        } else if ($mode=='passive') {
            $parameterlist = GetListDataFromTableWithSingleWhere($fromText, $selectText, $parameter['orderby'], '1=1 and p.active=0 ' . $firmWherePostFix, false);
        }

		echo '<div class="table-responsive">';
		echo '<table class="table table-bordered table-sm derm-table">';
		echo '<thead>';
		echo '<tr>';
		echo '<th width="4%">#</th>';
		echo '<th width="10%">İşlemler</th>';
		echo '<th>id</th>';
		foreach ($parameter['fields'] as $f) {
			if ($f['show']) {
				echo '<th>' . $f['label'] . '</th>';
			}
		}
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		$rowCount = 1;
		foreach ($parameterlist as $p) {
			echo '<tr>';
			echo '<td>' . $rowCount . '</td>';

			echo '<td>';
			echo $p['no_delete'] == 0 ? '<a href="javascript:;" class="btn btn-xs btn-danger mr-lg-2" onclick="DeleteParameter(' . $p['id'] . ');"><i class="la la-trash"></i>&nbsp;Remove</a>' : '';
			$sortOrderUpCheck = $p['sort_order'] > 1 ? '' : 'disabled';
			$sortOrderDownCheck = $p['sort_order'] != count($parameterlist) ? '' : 'disabled';
			echo '<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">';
			    if ($parameter['orderby']=='sort_order') {
                echo '<button type="button" class="btn btn-info btn-xs ' . $sortOrderUpCheck . '" onclick="ParameterOrderChange(' . $p['id'] . ', 1);"><i class="la la-angle-up"></i></button>';
                echo '<button type="button" class="btn btn-info btn-xs  ' . $sortOrderDownCheck . '" onclick="ParameterOrderChange(' . $p['id'] . ', 2);"><i class="la la-angle-down"></i></button>';
                }
                echo '<button type="button" class="btn btn-success btn-xs" onclick="LoadParameterData(' . $p['id'] . ')"><i class="la la-pencil"></i></button>';
                echo '<button type="button" class="btn btn-warning btn-xs" onclick="SwitchModeParameter(' . $p['id'] . ', ' . $p['active'] . ');"><i class="la la-retweet"></i></button>';
            echo '</div>';
			echo '</td>';

			echo '<td>' . HtmlDecode($p['id']) . '</td>';

			foreach ($parameter['fields'] as $f) {
				if ($f['show']) {
					if ($f['type'] == 'parameter') {
						echo '<td>' . HtmlDecode($p[$f['parameter'] . '_' . $f['param_field']]) . '</td>';
					}
					else if ($f['type'] == 'truefalse') {
						if ($p[$f['name']] == 0) {
							echo '<td>Hayır</td>';
						}
						else {
							echo '<td>Evet</td>';
						}
					}
					else {
						echo '<td>' . HtmlDecode($p[$f['name']]) . '</td>';
					}
				}
			}
			echo '</tr>';
			$rowCount++;
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';

	}
}

function LoadParameterData($cat, $parameter, $id)
{
	global $parameters;
	$json = array();
	if (empty($cat) || empty($parameter) || empty($id)) {
		JsonResult('empty', 'Parameter type or id not found', $id);
	}
	else {
		$data = GetSingleDataFromTable('param_' . $cat . '_' . $parameter, $id);
		if (!empty($data)) {
			$json['result'] = 'ok';
			$json['message'] = 'Load succeed';
			$json['parametertitle'] = $parameters[$cat]['categoryFields'][$parameter]['title'];
			foreach ($parameters[$cat]['categoryFields'][$parameter]['fields'] as $p) {
				//print_r($data);
				//echo $p['name'];
				$json[$p['name']] = HtmlDecode($data[$p['name']], true);
			}
			//print_r($json);
			echo json_encode($json);
		}
		else {
			JsonResult('fail', 'Parametre datası bulunamadı', $id);
		}
	}
}

function ParameterForm($post)
{
	global $parameters, $CurrentFirm;
	$emptyfield  = false;
    $uniquefield = false;
	$p = $parameters[$post['cat']]['categoryFields'][$post['parameter']];
	foreach ($p['fields'] as $f) {
		if ($f['required'] && empty($post[$f['name']])) {
			$emptyfield = true;
			break;
		} else if ($f['unique']) {
            // $checkExist = GetRowCountWithSingleWhere('param_' . $post['cat'] . '_' . $post['parameter'], $f['name'] . '="' . $post[$f['name']] . '" and id<>' . $post['id']. ' and sirket_id=' . $CurrentFirm['id'], false);
            $checkExist = GetRowCountWithSingleWhere('param_' . $post['cat'] . '_' . $post['parameter'], $f['name'] . '="' . $post[$f['name']] . '" and ' . $f['name'] .  '<>"" and id<>' . $post['id']. ' and sirket_id=' . $CurrentFirm['id'], false);
            if ($checkExist > 0) {
                $uniquefield = true;
                break;
            }
        }
	}
	if ($emptyfield) {
		ToastrJsonResult('ok', 0, 'warning', 'Uyarı', 'Lütfen zorunlu alanları doldurun');
	} else if ($uniquefield) {
        ToastrJsonResult('ok', 0, 'warning', 'Uyarı', 'Kaydin benzersiz olmasi gerekli');
    } else {
		$fields = array();
		$values = array();

		if (!$p['isCommon']) {
			$fields[] = 'sirket_id';
			$values[] = $CurrentFirm['id'];
		}

		foreach ($p['fields'] as $f) {
			//$val = MysqlSecureText($post[$f['name']]);
			$val = $post[$f['name']];
			if (isset($f['dotfix']) && $f['dotfix']) {
				$val = DotFix($val);
			}
			if ($f['name'] != 'id') {
				$fields[] = $f['name'];
				$values[] = $val;
			}
		}

		$firmWherePostFix = $p['isCommon'] ? '' : ' AND sirket_id=' . $CurrentFirm['id'];

		if ($post['id'] > 0) {
			if (UpdateTable2WithSingleWhere('param_' . $post['cat'] . '_' . $post['parameter'], $fields, $values, 'id=' . $post['id'] . $firmWherePostFix)) {
				ToastrJsonResult('ok', $post['id'], 'success', 'Başarılı', 'Parametre Güncellendi');
			}
			else {
				ToastrJsonResult('fail', 0, 'error', 'Uyarı', 'Güncelleme sırasında hata oluştu');
			}
		}
		else {
			if (AddToTable('param_' . $post['cat'] . '_' . $post['parameter'], $fields, $values, true)) {
				//$id = GetMaxIdOfTable('param_' . MysqlSecureText($post['parameter']));
				$id = GetMaxIdOfTable('param_' . $post['cat'] . '_' . $post['parameter']);
				ToastrJsonResult('ok', $id, 'success', 'Başarılı', 'Parametre Eklendi');
			}
			else {
				ToastrJsonResult('fail', 0, 'error', 'Uyarı', 'Ekleme sırasında hata oluştu');
			}
		}
	}
}

function SwitchModeParameter($cat, $parameter, $id, $currentmode)
{
    if ($currentmode==1) {
        $tomode=0;
    } else if ($currentmode==0) {
        $tomode=1;
    }

    if (empty($cat) || empty($parameter) || empty($id)) {
        JsonResult('empty', 'Parameter type or id not found', $id);
    }
    else {
        if (UpdateTable2WithSingleWhere('param_' . $cat . '_' . $parameter, array('active'), array($tomode), 'id=' . $id, false)) {
            if ($tomode==1) {
                ToastrJsonResult('ok', $id, 'success', 'Başarılı', 'Parametre aktif olarak değiştirildi');
            } else if ($tomode==0) {
                ToastrJsonResult('ok', $id, 'success', 'Başarılı', 'Parametre pasif olarak değiştirildi');
            }
        }
        else {
            ToastrJsonResult('fail', $id, 'error', 'Uyarı', 'Mode değiştirme sırasında hata oluştu');
        }
    }
}

function DeleteParameter($cat, $parameter, $id)
{
	if (empty($cat) || empty($parameter) || empty($id)) {
		JsonResult('empty', 'Parameter type or id not found', $id);
	}
	else {
		if (DeleteById('param_' . $cat . '_' . $parameter, 'id', $id, false)) {
			ToastrJsonResult('ok', $id, 'success', 'Başarılı', 'Parametre Silindi');
		}
		else {
			ToastrJsonResult('fail', $id, 'error', 'Uyarı', 'Silme sırasında hata oluştu');
		}
	}
}

function ParameterOrderChange($id, $cat, $parameter, $direction)
{
	if (empty($id) || empty($cat) || empty($parameter) || empty($direction)) {
		ToastrJsonResult('emtpy', 0, 'error', 'Hata', 'Parametre, id yada sıralama bulunamadı');
	}
	else {
		$process = false;
		if ($direction == 1) {
			$process = SortOrderUp('param_' . $cat . '_' . $parameter, $id);
		}
		else if ($direction == 2) {
			$process = SortOrderDown('param_' . $cat . '_' . $parameter, $id);
		}
		if ($process) {
			ToastrJsonResult('ok', $id, 'success', 'Başarılı', 'Sıralama değiştirildi');
		}
		else {
			ToastrJsonResult('fail', $id, 'error', 'Uyarı', 'Sıralama değiştirme sırasında hata oluştu');
		}
	}
}