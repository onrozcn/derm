<div id="odemeOnayModal" class="modal fade" tabindex="0">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ödeme Onayla</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="odemeOnayForm" action="<?php echo $siteUrl; ?>actions/odmOdemeTakip.php?Action=odemeOnayKaydet">
                <div class="modal-body">
                    <div class="col-12">

                        <input type="hidden" name="odeme_onay_id" id="odeme_onay_id" value="0">
                        <input type="hidden" name="odeme_durum" id="odeme_durum" value="0">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="kt-portlet kt-iconbox kt-iconbox--animate">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__icon">
                                                <a href="javascript:;" class="kt-media kt-media--circle kt-media--success">
                                                    <span class="kt-media kt-media--circle kt-media--success" id="borclualan"></span>
                                                </a>
                                            </div>
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title"><span id="tutaralan"></span> <span id="parabirimialan"></span></h3>
                                                <div class="kt-iconbox__content" id="alacaklialan"></div>
                                            </div>
                                            <div id="odemeOnayIptalLoaction"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Kur</label>
                                <input type="text" inputmode="decimal" class="form-control" name="odeme_onay_kur" id="odeme_onay_kur" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Ödeme Yöntemi</label>
                                <select class="form-control" name="odeme_onay_yontemi_id" id="odeme_onay_yontemi_id">
                                    <option value="0"></option>
                                    <? $param_odm_odemeyontemleri = GetListDataFromTableWithSingleWhere('param_odm_odemeyontemleri', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_odemeyontemleri as $data) { ?>
                                        <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['yontem']?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Ödendiği Tarih</label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" inputmode="none" name="odeme_onay_odendigi_tarih" id="odeme_onay_odendigi_tarih" autocomplete="off"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-3">
                                <label>Banka</label>
                                <input type="text" class="form-control" name="odeme_onay_banka" id="odeme_onay_banka" autocomplete="off" readonly >
                            </div>
                            <div class="form-group col-9">
                                <label>İban</label>
                                <input type="text" class="form-control" name="odeme_onay_iban" id="odeme_onay_iban" autocomplete="off" readonly >
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="form-group col">
                                <button type="submit" class="btn btn-outline-primary btn-block btn-elevate mb-3"><i class="fal fa-save"></i>Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

