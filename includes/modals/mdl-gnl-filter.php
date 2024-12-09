<div id="filtrele" class="modal modal-ls fade" tabindex="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="odeme_title">Filtre</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="filtrele">
                <div class="modal-body kt-shape-bg-color-1">


                    <div class=" col-12">

                        <div class="form-row">
                            <div class="form-group form-group-sm col-6">
                                <label>Sayfa</label>
                                <select class="form-filter form-control form-control-sm" id="page">
                                    <option value="0" selected="selected">Hepsi</option>
                                    <option value="1">Ilk Sayfa</option>
                                    <option value="last">Son Sayfa</option>
                                </select>
                            </div>

                            <div class="form-group form-group-sm col-6">
                                <label>Sırala</label>
                                <select class="form-filter form-control form-control-sm" id="orderBy">
                                    <option value="1" selected="selected">Durum, Ödendiği Tar, Vade Tar, Tutar</option>
                                    <option value="2">Vade Tar, Borclu Sirket</option>
                                    <option value="3">Durum, Ödendiği Tar, Vade Tar, Tutar</option>
                                    <option value="4">Kayıt</option>
                                    <option value="5">Ödeme Planı</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Hızlı Arama</label>
                                <input type="text" class="form-filter form-control form-control-sm" id="ff_quickSearch" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Kategori</label>
                                <select class="form-filter form-control form-control-smQ selectpicker" multiple data-actions-box="true" multiple data-selected-text-format="count > 5" id="ff_kategoriId">
                                    <? $param_odm_kategoriler = GetListDataFromTableWithSingleWhere('param_odm_kategoriler', '*', 'sort_order', 'sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_kategoriler as $data) { ?>
                                        <option value="<?= $data['id'] ?>" selected="selected"><?=$data['kategori']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Evrak No</label>
                                <input type="text" class="form-filter form-control form-control-sm" id="ff_evrakno" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Borçlu</label>
                                <select class=" form-control form-control-sm selectpicker" multiple data-actions-box="true" multiple data-selected-text-format="count > 5" id="ff_borcluId">
                                    <? $param_odm_borclusirketler = GetListDataFromTableWithSingleWhere('param_odm_borclusirketler', '*', 'sort_order', 'sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_borclusirketler as $data) { ?>
                                        <option value="<?= $data['id'] ?>" selected="selected"><?=$data['tag']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Ödeme Yeri</label>
                                <div class="typeahead form-control" style="border: 0; padding: 0px">
                                    <div id="scrollable-dropdown-menu">
                                        <div class="kt-input-icon kt-input-icon--right">
                                            <input type="text" class="form-control" id="ff_odemeyeri_typeahead" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: 0;border-bottom-right-radius: 0;" autocomplete="off"/>
                                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span id="ff_odemeyeri_search"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <span id="ff_odemeyeri_validation"></span>
                                <input type="hidden" class=" form-control form-control-sm" id="ff_odemeyeri_id" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col-7">
                                <label>Cinsi</label>
                                <input type="text" class=" form-control form-control-sm" id="ff_cinsi" autocomplete="off">
                            </div>

                            <div class="form-group form-group-sm col-5">
                                <label>Döviz</label>
                                <select class=" form-control form-control-sm selectpicker" multiple data-actions-box="true" multiple id="ff_dovizId">
                                    <? $param_ana_parabirimleri = GetListDataFromTableWithSingleWhere('param_ana_parabirimleri', '*', 'sort_order', 'sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_ana_parabirimleri as $data) { ?>
                                        <option value="<?= $data['id'] ?>" selected="selected"><?=$data['kod']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Vade Tarihi</label>
                                <input type="text" class="form-control form-control-sm" id="ff_vadeDR" autocomplete="off">
                                <input type="hidden" class="" id="ff_vadeDRInput">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col-4">
                                <label>Talep</label>
                                <select class=" form-control form-control-sm selectpicker" multiple data-actions-box="true" id="ff_talep">
                                    <option value="0" selected="selected">&#9743;</option>
                                    <option value="1" selected="selected">&#9742;</option>
                                </select>
                            </div>

                            <div class="form-group form-group-sm col-8">
                                <label>Öncelik</label>
                                <select class=" form-control form-control-sm selectpicker" multiple data-actions-box="true" id="ff_oncelik">
                                    <option value="0" selected="selected">&#9734;</option>
                                    <option value="1" selected="selected">&#9733;</option>
                                    <option value="2" selected="selected">&#9733;&#9733;</option>
                                    <option value="3" selected="selected">&#9733;&#9733;&#9733;</option>
                                    <option value="4" selected="selected">&#9733;&#9733;&#9733;&#9733;</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Ödeme Yöntemi</label>
                                <select class=" form-control form-control-sm selectpicker" multiple data-actions-box="true" multiple   id="ff_yontem">
                                    <? $param_odm_odemeyontemleri = GetListDataFromTableWithSingleWhere('param_odm_odemeyontemleri', '*', 'sort_order', 'sirket_id=' . $CurrentFirm['id']);
                                    foreach ($param_odm_odemeyontemleri as $data) { ?>
                                        <option value="<?= $data['id'] ?>" selected="selected"><?=$data['yontem']?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Ödendiği Tarih</label>
                                <input type="text" class="form-control form-control-sm" id="ff_odendigiDR" value="" autocomplete="off">
                                <input type="hidden" class="" id="ff_odendigiDRInput">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-group-sm col">
                                <label>Ödendi Durumu</label>
                                <select class=" form-control form-control-sm selectpicker" multiple data-actions-box="true" id="ff_durum">
                                    <option value="0" selected="selected">Ödenmedi</option>
                                    <option value="1" selected="selected">Ödendi</option>
                                </select>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-outline-primary btn-block btn-elevate"><i class="fal fa-filter"></i>Filtrele</button>

                        <button type="button" class="btn btn-outline-info btn-block btn-elevate" onclick="searchReset()"><i class="fal fa-undo"></i>Sıfırla</button>





                    </div>

                </div>
            </form>
        </div>
    </div>
</div>