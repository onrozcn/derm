<div id="anlikKurGuncelleManuelModal" class="modal fade" tabindex="0">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manuel Kur Güncelleme</h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
            </div>
            <form class="kt-form" name="anlikKurGuncelleManuelForm" action="<?php echo $siteUrl; ?>actions/odmOdemeTakip.php?Action=anlikKurGuncelleManuel">
                <div class="modal-body">
                    <div class="container col-lg-6 offset-lg-3">

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Dolar Kuru</label>
                                <input type="text" inputmode="decimal" class="form-control" name="anlikKurManualDegerUSD" id="anlikKurManualDegerUSD" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Euro Kuru</label>
                                <input type="text" inputmode="decimal" class="form-control" name="anlikKurManualDegerEUR" id="anlikKurManualDegerEUR" autocomplete="off"/>
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