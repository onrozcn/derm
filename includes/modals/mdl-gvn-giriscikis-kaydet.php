<?
if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisAdd'))) {
?>
<div id="girisCikisActionModal" class="modal modal-fs fade" tabindex="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="odeme_title">Yeni Kayıt Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="girisCikisActionForm" action="<?php echo $siteUrl; ?>actions/gvnGirisCikis.php?Action=GuvenlikGirisCikisKaydet" novalidate> /* -- novalidate --ios 14 oncesi datetime-local validate islemi bypass */
                <div class="modal-body">
                    <div class="col-lg-6 offset-lg-3">

                        <input type="hidden" name="id" id="girisCikis_id" value="0">

                        <div class="form-row">
                            <div id="girisfield" class="form-group col">
                                <label>Giriş Tarih ve Saat</label>
                                <div class="input-group">
                                    <input type="datetime-local" class="form-control" id="giris_tarih" name="giris_tarih" step="0" autocomplete="off"/>
                                </div>
                            </div>

                            <div id="cikisfield" class="form-group col">
                                <label>Çıkış Tarih ve Saat</label>
                                <div class="input-group">
                                    <input type="datetime-local" class="form-control" id="cikis_tarih" name="cikis_tarih" step="0" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div id="infofields" class="form-row">
                            <div class="form-group col-lg-3 col-6">
                                <label>Tür<span class="required">*</span></label>
                                <select class="form-control" name="arac_tur" id="arac_tur">

                                </select>
                            </div>

                            <div class="form-group col-lg-3 col-6">
                                <label>Plaka<span class="required">*</span></label>
                                <input type="text" inputmode="text" class="form-control inputmaskPlaka" name="plaka" id="plaka" autocomplete="off"/>
                            </div>

                            <div class="form-group col-lg-3 col-6">
                                <label>Firma<span class="required">*</span></label>
                                <input type="text" inputmode="text" class="form-control" name="firma" id="firma" autocomplete="off"/>
                            </div>

                            <div class="form-group col-lg-3 col-6">
                                <label>Ad Soyad<span class="required">*</span></label>
                                <input type="text" inputmode="text" class="form-control" name="ad_soyad" id="ad_soyad" autocomplete="off"/>
                            </div>
                        </div>

                        <div id="copfields" class="form-row">
                            <div class="form-group col">
                                <label>Fiş No<span class="required">*</span></label>
                                <input type="text" inputmode="numeric" maxlength="6" pattern="^[0-9]+$" class="form-control" name="fis_no" id="fis_no" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>KM<span class="required">*</span></label>
                                <input type="text" inputmode="numeric" maxlength="7" pattern="^[0-9]+$" class="form-control" name="km" id="km" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>Çöp Sahası<span class="required">*</span></label>
                                <select class="form-control"  name="cop_saha" id="cop_saha">
                                    <option value="0">Seçiniz</option>
                                    <option value="1">Kaklık</option>
                                    <option value="2">Kocabaş</option>
                                    <option value="3">Diğer</option>
                                </select>
                            </div>
                        </div>

                        <div id="hammaddefields" class="form-row">
                            <div class="form-group col">
                                <label>Ocak<span class="required">*</span></label>
                                <input type="text" inputmode="text" class="form-control" name="ocak" id="ocak" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>1. Tartı<span class="required">*</span></label>
                                <input type="text" inputmode="numeric" class="form-control" name="tarti1" id="tarti1" autocomplete="off"/>
                            </div>
                            <div class="form-group col">
                                <label>2. Tartı<span class="required">*</span></label>
                                <input type="text" inputmode="numeric" class="form-control" name="tarti2" id="tarti2" autocomplete="off"/>
                            </div>
                        </div>

                        <div id="aciklamagirisfields" class="form-row">
                            <div class="form-group col">
                                <label>Açıklama Giriş</label>
                                <input type="text" inputmode="text" class="form-control" name="aciklamagiris" id="aciklamagiris" autocomplete="off"/>
                            </div>
                        </div>

                        <div id="aciklamacikisfields" class="form-row">
                            <div class="form-group col">
                                <label>Açıklama Çıkış</label>
                                <input type="text" inputmode="text" class="form-control" name="aciklamacikis" id="aciklamacikis" autocomplete="off"/>
                            </div>
                        </div>












                        <div class="row text-center">
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary btn-elevate mr-3"><i class="fal fa-save"></i>Kaydet</button>
                                <button type="submit" class="btn btn-outline-danger btn-elevate " data-dismiss="modal"><i class="fal fa-times-circle"></i>İptal</button>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>