<div class="kt-header__topbar-item dropdown mr-3">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,10px">
		<span class="kt-header__topbar-icon"><i class="fa fa-industry-alt"></i></span>
	</div>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
		<form>

			<!-- begin:: Mycart -->
			<div class="kt-mycart">
				<div class="kt-mycart__head kt-head" style="background-image: url(assets/media/bg/bg-part-1.jpg);">
					<div class="kt-mycart__info">
						<span class="kt-mycart__icon"><i class="fa fa-industry-alt kt-font-success"></i></span>
						<h3 class="kt-mycart__title">Şirket Seçimi</h3>
					</div>
				</div>
				<div class="kt-mycart__body kt-scroll" data-scroll="true" data-height="245" data-mobile-height="200">

                    <?php foreach ($CurrentUser['firmList'] as $firm) {
                        $isActive = $firm['id'] == $CurrentFirm['id']; ?>
                        <div class="kt-mycart__item <?= ($isActive ? ' bg-info' : '') ?>" onclick="SelectFirm(<?= $firm['id'] ?>, '<?=$_SESSION["requesturl"]?>');">
                            <div class="kt-mycart__container">
                                <div class="kt-mycart__info">
                                    <?= $firm['tag'] ?>
                                    <span class="kt-mycart__desc"><?//= $firm['unvan'] ?></span>
                                </div>
                                <img width="150px" src="<?=$firm['logo']?>" title="">
                            </div>
                        </div>
                    <?php } ?>

                </div>
			</div>

			<!-- end:: Mycart -->
		</form>
	</div>
</div>