<div class="row mb-3">
    <div class="col-md-8">

        <form class="kt-form">
            <div class="form-row collapse" id="yakitCikisFilterGroup">
                <div class="form-group col">
                    <input type="text" class="form-control form-control-sm m-input m-input--square" id="formFilterTarih" autocomplete="off">
                    <input type="hidden" id="formFilterTarihStartEnd">
                    <div class="form-control-feedback">Tarih</div>
                </div>

                <div class="form-group col">
                    <select class="form-control form-control-sm" id="formFilterTankId">
                        <option value="all">Hepsi</option>
                        <? $param_dep_tanklar = GetListDataFromTableWithSingleWhere('param_dep_tanklar', '*', 'sort_order', 'sirket_id=' . $CurrentFirm['id']);
                        foreach ($param_dep_tanklar as $data) { ?>
                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?= $data['kisa_isim'] ?></option>
                        <? } ?>
                    </select>
                    <div class="form-control-feedback">Tank</div>
                </div>


                <div class="form-group col">
                    <select class="form-control form-control-sm" id="formFilterAracId">
                        <option value="all">Hepsi</option>
                        <? $param_dep_araclar = GetListDataFromTableWithSingleWhere('param_dep_araclar', '*', 'sort_order', 'sirket_id=' . $CurrentFirm['id']);
                        foreach ($param_dep_araclar as $data) { ?>
                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?= $data['plaka'] . ' - ' . $data['marka'] . ' ' . $data['model'] ?></option>
                        <? } ?>
                    </select>
                    <div class="form-control-feedback">Araç</div>
                </div>
                <div class="form-group col">
                    <select class="form-control form-control-sm" id="formFilterTeslimEden">
                        <option value="all">Hepsi</option>
                        <?php $yakitTeslimEtmeKullanicilar = UserListByPermission('depYakitTeslimEtmeUser', true);
                        foreach ($yakitTeslimEtmeKullanicilar as $data) { ?>
                            <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?= $data['name'] . ' ' . $data['surname'] ?></option>
                        <? } ?>
                    </select>
                    <div class="form-control-feedback">Teslim Eden</div>
                </div>
            </div>
        </form>


    </div>
    <div class="col-md-4 text-right">


        <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary btn-sm collapse" id="filterExec"><i class="fal fa-search"></i> Ara</button>
            <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#yakitCikisFilterGroup" aria-expanded="false" aria-controls="yakitCikisFilterGroup" id="filterToggleBtn"><i class="fal fa-filter"></i><span id="filterToggleBtnText">Filtre Göster</span></button>
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-file-export"></i><span class="d-none d-xl-inline">Dışa Aktar</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" id="exportBtnExcel"><i class="fal fa-file-excel"></i> Excel</a>
                    <a class="dropdown-item" href="#" id="exportBtnPdf"><i class="fal fa-file-pdf"></i> PDF</a>
                    <a class="dropdown-item" href="#" id="exportBtnPng"><i class="fal fa-file-image"></i> PNG</a>
                </div>
            </div>
        </div>




    </div>
</div>

