<?
//$cat = 'odm';
//$parameter = 'odemeyerleri';
//$p = $parameters[$cat]['categoryFields'][$parameter];
?>
<div id="parametermodal" class="modal fade" data-backdrop="static" tabindex="0">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Parametre: <span id="parametertitletext"></span></h5>
                <button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>
                </button>
            </div>
            <form name="ParameterForm" action="<?php echo $siteUrl; ?>actions/parameter.php?Action=ParameterForm">
<!--                <input type="text" name="id" id="ParameterFormId" value="1"/>-->
                <div class="modal-body">

                    <?php foreach ($p['fields'] as $field) {
                        if ($field['show']) { ?>
                            <div class="form-group">
                                <label for="PF<?php echo $field['name']; ?>"><?php echo $field['label']; ?> <?php if ($field['required'] || $field['unique']) { ?>
                                        <span class="required"><sup>(<?=$field['required']?'Gerekli':''?>  <?=$field['unique']?'Benzersiz':''?>)</sup></span><?php } ?></label>
                                <?php if ($field['type'] == 'varchar') { ?>
                                    <input type="text" class="form-control m-input m-input--square <?=isset($field['class']) ? $field['class'] : ''?>" name="<?=$field['name']?>" id="PF<?php echo $field['name']; ?>" placeholder="<?php echo $field['label']; ?>" maxlength="<?=$field['length']?>" autocomplete="off">
                                <?php }
                                else if ($field['type'] == 'parameter') {
                                    $p_get = GetListDataFromTable($field['parameter'], '*', 'sort_order'); ?>
                                    <select name="<?php echo $field['name']; ?>" id="PF<?php echo $field['name']; ?>" class="form-control m-input m-input--square">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach ($p_get as $p) { ?>
                                            <option value="<?php echo $p['id']; ?>"><?php echo HtmlDecode($p[$field['param_field']]); ?></option>
                                        <?php } ?>
                                    </select>
                                <?php }
                                else if ($field['type'] == 'truefalse') { ?>
                                    <select name="<?php echo $field['name']; ?>" id="PF<?php echo $field['name']; ?>" class="form-control m-input m-input--square">
                                        <option value="0">Hayır</option>
                                        <option value="1">Evet</option>
                                    </select>
                                <?php } else if ($field['type'] == 'color') { ?>
                                    <input class="form-control" type="color" name="<?php echo $field['name']; ?>" id="PF<?php echo $field['name']; ?>">
                                <?php } ?>
                            </div>
                        <?php }
                        else { ?>
                            <input type="hidden" name="<?php echo $field['name'] ?>" id="PF<?php echo $field['name'] ?>" value=""/>
                        <?php } ?>
                    <?php } ?>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"><span><i class="fas fa-save"></i><span>Kaydet</span></span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span><i class="fas fa-times-circle"></i>Kapat</span></button>
                </div>
            </form>
        </div>
    </div>
</div>