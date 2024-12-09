<?
if (checkPermission(array('superadmin', 'admin', 'odmOdemeTakipAction'))) {
$cat = 'odm';
$parameter = 'odemeyerleri';
$p = $parameters[$cat]['categoryFields'][$parameter];
?>
<div id="odemeKaydetModal" class="modal modal-ts fade" tabindex="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="odeme_title">Yeni Kayıt Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="odemeForm" action="<?php echo $siteUrl; ?>actions/odmOdemeTakip.php?Action=odemeKaydet">
                <div class="modal-body">
                    <div class="col-12">

                        <input type="hidden" name="id" id="odeme_id" value="0">

                        <div class="form-row">
                            <div class="form-group col-1">
                                <label>Kategori</label>
                                <select class="form-control"  name="odeme_kategori_id" id="odeme_kategori_id">
                                    <option value="0">Seçiniz</option>
                                    <? $param_odm_kategoriler = GetListDataFromTableWithSingleWhere('param_odm_kategoriler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_kategoriler as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['kategori']?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="form-group col-1">
                                <label>Evrak No</label>
                                <input type="text" inputmode="decimal" class="form-control" name="odeme_evrak_no" id="odeme_evrak_no" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Şirketler</label>
                                <select class="form-control"  name="odeme_borclu_sirket_id" id="odeme_borclu_sirket_id">
                                    <option value="0">Seçiniz</option>
                                    <? $param_odm_sirketler = GetListDataFromTableWithSingleWhere('param_odm_borclusirketler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_sirketler as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="form-group validated col-2">
                                <label>Ödeme Yeri</label>
                                <div class="typeahead">
                                    <div id="scrollable-dropdown-menu">
                                        <div class="kt-input-icon kt-input-icon--right">
                                        <input type="text" class="form-control" name="odeme_odemeyeri_typeahead" id="odeme_odemeyeri_typeahead" autocomplete="off"/>
                                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span id="odeme_odemeyeri_typeahead_search"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <span id="odeme_odemeyeri_typeahead_validation"></span>
                            </div>
                            <div class="form-group col collapse">
                                <label>odeme_odemeyeri_id</label>
                                <input type="text" class="form-control" name="odeme_odemeyeri_id" id="odeme_odemeyeri_id" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Cinsi</label>
                                <input type="text" class="form-control" name="odeme_cinsi" id="odeme_cinsi" autocomplete="off"/>
                            </div>
                            <div class="form-group col-2">
                                <label>Tutar</label>
                                <input type="text" class="form-control inputmaskDecimal" name="odeme_tutar_formul" id="odeme_tutar_formul" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Para Birimi</label>
                                <select class="form-control"  name="odeme_parabirimi_id" id="odeme_parabirimi_id">
                                    <? $param_ana_parabirimleri = GetListDataFromTableWithSingleWhere('param_ana_parabirimleri', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_ana_parabirimleri as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['kod']?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Vade Tarihi<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" inputmode="none" name="odeme_vade_tarihi" id="odeme_vade_tarihi" autocomplete="off"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label>Ödeme Yöntemi</label>
                                <select class="form-control"  name="odeme_yontemi_id" id="odeme_yontemi_id">
                                    <option value="0"></option>
                                    <? $param_odm_odemeyontemleri = GetListDataFromTableWithSingleWhere('param_odm_odemeyontemleri', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_odemeyontemleri as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['yontem']?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Düzenli</label>
                                <select class="form-control"  name="odeme_duzenli_odeme" id="odeme_duzenli_odeme">
                                    <option value="0">Hayır</option>
                                    <option value="1">Evet</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <button type="submit" class="btn btn-outline-primary btn-elevate mr-3"><i class="fal fa-save"></i>Kaydet</button>
                                <button type="button" class="btn btn-outline-success btn-elevate" tabIndex="-1" onclick="NewParameterData()"><i class="fal fa-id-card"></i>Yeni Kart Ekle</button>
                                <input type="hidden" id="cat" value="odm">
                                <input type="hidden" id="parameter" value="odemeyerleri">
                                <input type="hidden" id="parametertitlevalue" value="Ödeme Yeri">

                            </div>


                            <div class="col-6">
                                <div class="alert alert-warning kt-hidden" id="planAlert">
                                    <strong>Uyarı!</strong>&nbsp;Düzenlediğiniz kayıt ödeme planında.
                                </div>
                                <div id="firmaLastTransactionTableModal"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>