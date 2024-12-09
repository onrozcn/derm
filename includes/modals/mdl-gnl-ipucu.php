<?php if (isset($pages[GetPhpPageName()])) {
    $page = $pages[GetPhpPageName()]; ?>
    <div class="modal modal-sticky-bottom-right fade" id="ipucuModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-info-circle"></i> İpucu</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="kt-section">
                        <div class="kt-section__heading"><?php echo $page['title'] ?></div>
                        <div class="kt-section__desc">
                            <?php echo $page['description'] ?>
                        </div>
                    </div>
                    <?php if (isset($page['hotkeys']) && !empty($page['hotkeys'])) { ?>
                        <div class="kt-separator kt-separator--border-dashed"></div>
                        <div class="kt-section">
                            <div class="kt-section__heading">Kısayollar</div>
                            <div class="kt-section__desc">
                                <?php foreach ($page['hotkeys'] as $key => $hotkey) { ?>
                                    <div class="row">
                                        <div class="col-4"><p>
                                                <?php if (isset($hotkey['display']) && !empty($hotkey['display'])) {
                                                        echo '<kbd>' . implode("</kbd> + <kbd>", $hotkey['display']) . '</kbd>';
                                                    } else {
                                                        echo '<kbd>' . $key . '</kbd>';
                                                    } ?></p></div>
                                        <div class="col-8"><p><?php echo $hotkey['description'] ?></p></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>