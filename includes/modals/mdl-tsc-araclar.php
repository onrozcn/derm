<input type="hidden" name="id" value="<?=(isset($id) ? $id : 0)?>">
<div class="form-group">
	<label>Plaka</label>
	<input type="text" class="form-control m-input m-input--square" name="plaka" id="plaka" maxlength="10">
</div>
<div class="form-group">
	<label>Tip<span class="required">*</span></label>
	<select name="tip" id="tip" class="form-control m-input m-input--square">
		<option value="0">Seçiniz</option>
		<? $param_tsc_aractipi = GetListDataFromTableWithSingleWhere('param_tsc_aractipi', '*', 'sort_order', 'active=1');
		foreach ($param_tsc_aractipi as $data) { ?>
			<option value="<?=$data['id']?>"<?=(isset($tip) && !empty($tip) && $tip==$data['id'] ? ' selected' : '')?>><?=$data['tag']?></option>
		<? } ?>
	</select>
</div>
<div class="form-group">
	<label>Firma<span class="required">*</span></label>
	<select name="firma" id="firma" class="form-control m-input m-input--square">
		<option value="0">Seçiniz</option>
		<? $param_tsc_firma = GetListDataFromTableWithSingleWhere('param_tsc_firma', '*', 'sort_order', 'active=1');
		foreach ($param_tsc_firma as $data) { ?>
			<option value="<?=$data['id']?>"<?=(isset($firma) && !empty($firma) && $firma==$data['id'] ? ' selected' : '')?>><?=$data['tag']?></option>
		<? } ?>
	</select>
</div>
<div class="form-group">
	<label>Marka</label>
	<input type="text" value="<?=(isset($marka) ? $marka : '')?>" class="form-control m-input m-input--square" name="marka" id="marka" maxlength="10">
</div>
<div class="form-group">
	<label>Model</label>
	<input type="text" value="<?=(isset($model) ? $model : '')?>" class="form-control m-input m-input--square" name="model" id="model" maxlength="10">
</div>
<div class="form-group">
	<label>Yıl<span class="required">*</span></label>
	<select name="yil" id="yil" class="form-control m-input m-input--square">
		<option value="0">Seçiniz</option>
		<? define('DOB_YEAR_START', 1900);
		$current_year = date('Y')+1;
		for ($listYear = $current_year; $listYear >= DOB_YEAR_START; $listYear--)
		{ ?>
			<option value="<?=$listYear?>"<?=(isset($yil) && !empty($yil) && $yil==$listYear ? ' selected' : '')?>><?=$listYear?></option>
		<? } ?>
	</select>
</div>

<div class="form-group">
	<label>Tescil Tarihi<span class="required">*</span></label>
	<div class="input-group">
		<input type="text" class="form-control m-input" value="<?=(isset($tescilTarihi) ? DateFormat($tescilTarihi, 'd/m/Y') : '')?>" name="tescilTarihi" id="tescilTarihi"/>
		<div class="input-group-append">
			<span class="input-group-text">
				<i class="la la-calendar"></i>
			</span>
		</div>
	</div>
</div>