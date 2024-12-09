<?
if (checkPermission(array('superadmin', 'admin', 'hamGirisPageView'))) {
?>
<div id="hamGirisActionModal" class="modal modal-fs fade" tabindex="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="odeme_title">Yeni Kayıt Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="hamGirisActionForm" action="<?php echo $siteUrl; ?>actions/hamGiris.php?Action=HamGirisKaydet" novalidate> /* -- novalidate --ios 14 oncesi datetime-local validate islemi bypass */
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <input type="hidden" name="id" id="hamGiris_id" value="0">


                            <div class="form-row">
                                <div class="form-group col-md-3 col-6">
                                    <label>Tarih</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tarih"  autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-6">
                                    <label>Nakliye Firma</label>
                                    <select class="form-control" name="nakliye_id">
                                        <option value="0">Seçiniz</option>
                                        <? $param_ham_nakliyeciler = GetListDataFromTableWithSingleWhere('param_ham_nakliyeciler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                        foreach ($param_ham_nakliyeciler as $data) { ?>
                                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-6">
                                    <label>Nakliye Plaka</label>
                                    <input type="text" class="form-control inputmaskPlaka" name="nakliye_plaka" autocomplete="off"/>
                                </div>
                                <div class="form-group col-md-3 col-6">
                                    <label>Nakliye Sofor</label>
                                    <input type="text" class="form-control" name="nakliye_sofor" autocomplete="off"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>Kantar Fiş No</label>
                                    <input type="text" class="form-control" name="nakliye_fis_no" autocomplete="off"/>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tonaj</label>
                                    <input type="number" class="form-control" name="nakliye_tonaj" autocomplete="off"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label>Ocak</label>
                                    <select class="form-control" name="nakliye_ocak_id">
                                        <option value="0">Seçiniz</option>
                                        <? $param_ham_ocaklar = GetListDataFromTableWithSingleWhere('param_ham_ocaklar', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                        foreach ($param_ham_ocaklar as $data) { ?>
                                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Saha</label>
                                    <select class="form-control" name="nakliye_saha_id">
                                        <option value="0">Seçiniz</option>
                                        <? $param_ham_sahalar = GetListDataFromTableWithSingleWhere('param_ham_sahalar', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                        foreach ($param_ham_sahalar as $data) { ?>
                                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Sefer No</label>
                                    <input type="number" class="form-control" name="nakliye_sefer_no" autocomplete="off"/>
                                    <div class="form-control-feedback" id="nakliye_sefer_no_feedback"></div>
                                </div>
                            </div>
                            <div class="form-row bg-secondary pt-4 pr-4 pl-4 mb-4">


                                <div class="form-group col-md-2 col">
                                    <label>Ocak</label>
                                    <select class="form-control" name="wiz_tas_ocak_id">
                                        <option value="0">Seçiniz</option>
                                        <? $param_ham_ocaklar = GetListDataFromTableWithSingleWhere('param_ham_ocaklar', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                        foreach ($param_ham_ocaklar as $data) { ?>
                                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col">
                                    <label>Tür</label>
                                    <select class="form-control" name="wiz_tas_tur_id">
                                        <option value="0">Seçiniz</option>
                                        <? $param_ham_turler = GetListDataFromTableWithSingleWhere('param_ham_turler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                        foreach ($param_ham_turler as $data) { ?>
                                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col">
                                    <label>Kalite</label>
                                    <select class="form-control" name="wiz_tas_kalite_id">
                                        <option value="0">Seçiniz</option>
                                        <? $param_ham_kaliteler = GetListDataFromTableWithSingleWhere('param_ham_kaliteler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                        foreach ($param_ham_kaliteler as $data) { ?>
                                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['isim']?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-6">
                                    <label>İrsaliye No</label>
                                    <input type="text" class="form-control" name="wiz_irsaliye_no" autocomplete="off"/>
                                </div>
                                <div class="form-group col-md-1 col-6">
                                    <label>Adet</label>
                                    <input type="number" class="form-control" name="wiz_tas_adet" min="1" value="1" autocomplete="off"/>
                                </div>
                                <div class="form-group col-md-3 col">
                                    <label>&nbsp;</label>
                                    <a href="javascript:;" class="btn btn-success form-control" onclick="CloneWiz()"><i class="fa fa-fw fa-magic"></i> Otomatik Oluştur</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <span style="font-size: 25px;">Taş Detayları</span>
                            <a href="javascript:;" class="btn btn-success pull-right" onclick="Clone()" ><i class="fa fa-fw fa-indent"></i> Satir Ekle</a>
                        </div>
                        <div class="col-12">
                            <div id="packings_list"></div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer p-5 pb-6">
                    <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i>Kaydet</button>
                    <button type="submit" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fal fa-times-circle"></i>İptal</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php } ?>