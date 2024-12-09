<div id="nakliyeGirisModal" class="modal modal-fs fade" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Nakliye Giriş Ekle
                </h4>
                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="m-form m-form--state" name="yakitCikisForm" action="<?php echo $siteUrl; ?>actions/depYakitCikis.php?Action=yakitCikisKaydet">
                <div class="modal-body">
                    <input type="hidden" name="id" id="yakitCikis_id" value="0">

                    <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                            <label>Tarih<span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control m-input datepicker" name="tarih" id="yakitCikis_tarih" autocomplete="off" readonly="true">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                            <label>Araçlar</label>
                            <select class="form-control m-input m-input--square"  name="arac_id" id="yakitCikis_arac_id">
                                <option value="0">Seçiniz</option>
                                <? $param_dep_araclar = GetListDataFromTableWithSingleWhere('param_dep_araclar', '*', 'sort_order', 'active=1');
                                foreach ($param_dep_araclar as $data) { ?>
                                <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['plaka'] .' - '. $data['marka'] .' '. $data['model']?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3 offset-md-3" id="yakitCikis_ilk_km_formgroup">
                            <label>İlk KM</label>
                            <input type="number" pattern="[0-9]*" class="form-control m-input m-input--square" name="ilk_km" id="yakitCikis_ilk_km" autocomplete="off" readonly>
                            <div class="form-control-feedback" id="yakitCikis_ilk_km_feedback"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Son KM</label>
                            <input type="number" pattern="[0-9]*" class="form-control m-input m-input--square" name="son_km" id="yakitCikis_son_km" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3 offset-md-3">
                            <label>Litre</label>
                            <input type="number" pattern="[0-9]*" class="form-control m-input m-input--square" name="litre" id="yakitCikis_litre" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Teslim Eden</label>
                            <select class="form-control m-input m-input--square"  name="teslim_eden_id" id="yakitCikis_teslim_eden_id">
                                <option value="0">Seçiniz</option>
                                <?php $yakitTeslimEtmeKullanicilar = UserListByPermission('depYakitTeslimEtmeUser');
                                foreach ($yakitTeslimEtmeKullanicilar as $data) {?>
                                <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['name'] .' '. $data['surname']?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                            <textarea class="form-control m-input m-input--square" name="aciklama" id="yakitCikis_aciklama" autocomplete="off" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="submit" class="btn btn-outline-primary m-btn m-btn--icon">
                        <span><i class="fas fa-save"></i><span>Kaydet</span></span>
                    </button>
                    <button type="submit" class="btn btn-outline-metal m-btn m-btn--icon" data-dismiss="modal">
                        <span><i class="fas fa-times-circle"></i><span>Kapat</span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
