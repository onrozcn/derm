<? if(checkPermission(array('superadmin', 'admin', 'depYakitGirisAdd'))) { ?>
<div id="yakitGirisModal" class="modal modal-fs fade" tabindex="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakıt Girişi Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="yakitGirisForm" action="<?php echo $siteUrl; ?>actions/depYakitGiris.php?Action=yakitGirisKaydet">
                <div class="modal-body">
                    <div class="container col-lg-6 offset-lg-3">

                        <input type="hidden" name="id" id="yakitGiris_id" value="0">

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Tanklar</label>
                                <select class="form-control"  name="tank_id" id="yakitGiris_tank_id">
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
                                    <input type="text" class="form-control datepicker" inputmode="none" name="tarih" id="yakitGiris_tarih" autocomplete="off"/>
                                    <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Firma</label>
                                <input type="text" class="form-control" name="firma" id="yakitGiris_firma" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Plaka</label>
                                <input type="text" class="form-control" name="plaka" id="yakitGiris_plaka" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Litre</label>
                                <input type="text" inputmode="decimal" class="form-control" name="litre" id="yakitGiris_litre" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Reel Litre</label>
                                <input type="text" inputmode="decimal" class="form-control" name="litre_reel" id="yakitGiris_litre_reel" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Fiyat</label>
                                <input type="text" inputmode="decimal" class="form-control" name="fiyat" id="yakitGiris_fiyat" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>İskonto</label>
                                <input type="text" inputmode="decimal" class="form-control" name="iskonto" id="yakitGiris_iskonto" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Teslim Alan</label>
                                <select class="form-control" name="teslim_alan_id" id="yakitGiris_teslim_alan_id"">
                                <option value="0">Seçiniz</option>
                                <?php $yakitTeslimAlmaKullanicilar = UserListByPermission('depYakitTeslimAlmaUser', true);
                                foreach ($yakitTeslimAlmaKullanicilar as $data) {?>
                                    <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['name'] .' '. $data['surname']?></option>
                                <? } ?>
                                </select>
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