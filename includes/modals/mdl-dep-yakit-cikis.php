<? if(checkPermission(array('superadmin', 'admin', 'depYakitCikisAdd'))) { ?>
<div id="yakitCikisModal" class="modal modal-fs fade" tabindex="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakıt Çıkışı Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="yakitCikisForm" action="<?php echo $siteUrl; ?>actions/depYakitCikis.php?Action=yakitCikisKaydet">
                <div class="modal-body">
                    <div class="container col-lg-6 offset-lg-3">

                        <input type="hidden" name="id" id="yakitCikis_id" value="0">

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Tanklar</label>
                                <select class="form-control"  name="tank_id" id="yakitCikis_tank_id">
                                    <option value="0">Seçiniz</option>
                                    <? $param_dep_tanklar = GetListDataFromTableWithSingleWhere('param_dep_tanklar', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_dep_tanklar as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['kisa_isim']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Tarih<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" inputmode="none" name="tarih" id="yakitCikis_tarih" autocomplete="off"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Araçlar</label>
                                <select class="form-control"  name="arac_id" id="yakitCikis_arac_id">
                                    <option value="0">Seçiniz</option>
                                    <? $param_dep_araclar = GetListDataFromTableWithSingleWhere('param_dep_araclar', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_dep_araclar as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['plaka'] .' - '. $data['marka'] .' '. $data['model']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="yakitCikis_ilk_son_km_formgroup">
                            <div class="form-group col" id="yakitCikis_ilk_km_formgroup">
                                <label>İlk KM</label>
                                <input type="text" inputmode="decimal" class="form-control" name="ilk_km" id="yakitCikis_ilk_km" autocomplete="off" Qreadonly/>
                                <div class="form-control-feedback" id="yakitCikis_ilk_km_feedback"></div>
                            </div>
                            <div class="form-group col" id="yakitCikis_son_km_formgroup">
                                <label>Son KM</label>
                                <input type="text" inputmode="decimal" class="form-control" name="son_km" id="yakitCikis_son_km" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Litre</label>
                                <input type="text" inputmode="decimal" class="form-control" name="litre" id="yakitCikis_litre" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Teslim Eden</label>
                                <select class="form-control"  name="teslim_eden_id" id="yakitCikis_teslim_eden_id">
                                    <option value="0">Seçiniz</option>
                                    <?php $yakitTeslimEtmeKullanicilar = UserListByPermission('depYakitTeslimEtmeUser', true);
                                    foreach ($yakitTeslimEtmeKullanicilar as $data) {?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['name'] .' '. $data['surname']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Açıklama</label>
                                <textarea class="form-control" name="aciklama" id="yakitCikis_aciklama" rows="3" autocomplete="off"></textarea>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer p-5 pb-6">
                    <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i>Kaydet</button>
                    <button type="submit" class="btn btn-outline-secondary " data-dismiss="modal"><i class="fal fa-times-circle"></i>İptal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>