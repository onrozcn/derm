<div class="kt-header__topbar-item kt-header__topbar-item--user">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,10px">
		<span class="kt-header__topbar-welcome kt-visible-desktop">Merhaba,</span>
		<span class="kt-header__topbar-username kt-visible-desktop"><?=$CurrentUser['name']?></span>
		<img alt="Pic" src="<?=$CurrentUser['avatar']?>" />
		<span class="kt-header__topbar-icon kt-bg-brand kt-font-lg kt-font-bold kt-font-light kt-hidden">S</span>
		<span class="kt-header__topbar-icon kt-hidden"><i class="flaticon2-user-outline-symbol"></i></span>
	</div>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

		<!--begin: Head -->
		<div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
			<div class="kt-user-card__avatar">
				<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?=mb_substr($CurrentUser['name'], 0, 1, 'UTF-8')?><?=mb_substr($CurrentUser['surname'], 0, 1, 'UTF-8')?></span>
			</div>
			<div class="kt-user-card__name">
				<?=$CurrentUser['name']?> <?=$CurrentUser['surname']?>
			</div>
            <?/*
			<div class="kt-user-card__badge">
				<span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
			</div>
            */?>
		</div>

		<!--end: Head -->

		<!--begin: Navigation -->
		<div class="kt-notification">
			<a href="#" class="kt-notification__item">
				<div class="kt-notification__item-icon">
					<i class="flaticon2-calendar-3 kt-font-success"></i>
				</div>
				<div class="kt-notification__item-details">
					<div class="kt-notification__item-title kt-font-bold">Profilim</div>
					<div class="kt-notification__item-time">Hesap ayarları ve daha fazlası</div>
				</div>
			</a>
			<a href="#" class="kt-notification__item">
				<div class="kt-notification__item-icon">
					<i class="flaticon2-mail kt-font-warning"></i>
				</div>
				<div class="kt-notification__item-details">
					<div class="kt-notification__item-title kt-font-bold">Mesajlarım</div>
					<div class="kt-notification__item-time">İletişimde kal</div>
				</div>
			</a>
			<a href="#" class="kt-notification__item">
				<div class="kt-notification__item-icon">
					<i class="flaticon2-rocket-1 kt-font-danger"></i>
				</div>
				<div class="kt-notification__item-details">
					<div class="kt-notification__item-title kt-font-bold">Aktivitelerim</div>
					<div class="kt-notification__item-time">Kayıtlar ve bildirimler</div>
				</div>
			</a>
			<a href="#" class="kt-notification__item">
				<div class="kt-notification__item-icon">
					<i class="flaticon2-hourglass kt-font-brand"></i>
				</div>
				<div class="kt-notification__item-details">
					<div class="kt-notification__item-title kt-font-bold">Görevler</div>
					<div class="kt-notification__item-time">Son görev ve projeler</div>
				</div>
			</a>
			<a href="#" class="kt-notification__item">
				<div class="kt-notification__item-icon">
					<i class="flaticon2-cardiogram kt-font-warning"></i>
				</div>
				<div class="kt-notification__item-details">
					<div class="kt-notification__item-title kt-font-bold">Bildirimler</div>
					<div class="kt-notification__item-time">Okunmamış <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 yeni bildirim</span></div>
				</div>
			</a>
			<div class="kt-notification__custom kt-space-between">
				<a href="source/logout.php" class="btn btn-label btn-label-brand btn-sm btn-bold">Çıkış Yap</a>
			</div>
		</div>

		<!--end: Navigation -->
	</div>
</div>