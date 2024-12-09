<div class="kt-subheader kt-grid__item" id="kt_subheader" style="min-height: 37px">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                <?= $pageTitle ?> </h3>
            <span class="kt-subheader__separator kt-hiddenQ"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="index.php" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <?= $pageBreadcrumbs ?>
                <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
            </div>
        </div>
        <?php if (isset($pages[GetPhpPageName()])) { ?>
            <div class="kt-subheader__toolbar">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ipucuModal"><i
                            class="far fa-info-circle"></i>İpucu</a>
            </div>
        <?php } ?>
    </div>
</div>