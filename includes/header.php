<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
	<div class="kt-header__top">
		<div class="kt-container  kt-container--fluid ">

			<!-- begin:: Brand -->
			<div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
				<div class="kt-header__brand-logo">
					<a href="index.php">
						<img alt="Logo" src="assets/media/logos/logo.svg" class="kt-header__brand-logo-default" />
						<img alt="Logo" src="assets/media/logos/logo_inverse.svg" class="kt-header__brand-logo-sticky" />
					</a>
				</div>
			</div>

			<!-- end:: Brand -->

			<!-- begin:: Header Topbar -->
			<div class="kt-header__topbar">

				<!--begin: Search -->
                <?php require_once('includes/header-topbar-search.php'); ?>
				<!--end: Search -->

				<!--begin: Notifications -->
                <? if(checkPermission(array('superadmin', 'admin'))) { ?>
                <?php require_once('includes/header-topbar-notifications.php'); ?>
                <? } ?>
				<!--end: Notifications -->

				<!--begin: Quick actions -->
                <? if(checkPermission(array('superadmin', 'admin'))) { ?>
                <?php require_once('includes/header-topbar-quickactions.php'); ?>
                <? } ?>
				<!--end: Quick actions -->

				<!--begin: Cart -->
                <?php require_once('includes/header-topbar-cart.php'); ?>
				<!--end: Cart-->

				<!--begin: User bar -->
                <?php require_once('includes/header-topbar-userbar.php'); ?>
				<!--end: User bar -->

				<!--begin: Quick panel toggler -->
                <? if(checkPermission(array('superadmin', 'admin'))) { ?>
                <?php require_once('includes/header-topbar-quickpaneltoggler.php'); ?>
                <? } ?>
				<!--end: Quick panel toggler -->
			</div>

			<!-- end:: Header Topbar -->
		</div>
	</div>
	<div class="kt-header__bottom">
		<div class="kt-container  kt-container--fluid ">

			<!-- begin: Header Menu -->
            <?php require_once('includes/header-menu.php'); ?>

			<!-- end: Header Menu -->
		</div>
	</div>
</div>