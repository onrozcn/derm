<div id="kt_quick_panel" class="kt-quick-panel">
	<a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
	<div class="kt-quick-panel__nav">
		<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x" role="tablist">
			<li class="nav-item active">
				<a class="nav-link active" data-toggle="tab" href="#donanimlar" role="tab">Donanımlar</a>
			</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#v1" role="tab">v1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#v2" role="tab">v2</a>
            </li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#kt_quick_panel_tab_settings" role="tab">Ayarlar</a>
			</li>
		</ul>
	</div>
	<div class="kt-quick-panel__content">
        <div class="tab-content">



            <div class="tab-pane fade show kt-scroll active" id="donanimlar" role="tabpanel">

                <?php
                /*

                function onur($ip_addr) {
                    if (!exec("ping -n 1 -w 1 " . $ip_addr . " 2>NUL > NUL && (echo 0) || (echo 1)")) {
                        echo '<i class="fa fa-check-circle"></i>';
                    } else {
                        echo '<i class="fa fa fa-times-circle"></i>';
                    }
                }


                */
                ?>

                <div class="kt-head">
                    <h3 class="kt-head__title">
                        Herşey Yolunda
                    </h3>
                </div>

                <div class="kt-grid-nav kt-grid-nav--skin-light">
                    <div class="kt-grid-nav__row">

                        <a href="http://10.0.0.31" target="_blank" class="kt-grid-nav__item">
						<span class="kt-grid-nav__icon">
							<img src="assets/img/quickbar-items/af24.png">
                        </span>
                            <span class="kt-grid-nav__title">AF24</span>
                            <span class="kt-grid-nav__desc">Dekor Side</span>
                            <span class="kt-grid-nav__desc"><?/*onur('10.0.0.31')*/?> 10.0.0.31</span>
                        </a>

                        <a href="http://10.0.0.32" target="_blank" class="kt-grid-nav__item">
						<span class="kt-grid-nav__icon">
							<img src="assets/img/quickbar-items/af24.png">
                        </span>
                            <span class="kt-grid-nav__title">AF24</span>
                            <span class="kt-grid-nav__desc">Dentas Side</span>
                            <span class="kt-grid-nav__desc"><?/*onur('10.0.0.32')*/?> 10.0.0.32</span>
                        </a>



                    </div>
                </div>

            </div>


            <div class="tab-pane fade show kt-scroll" id="v1" role="tabpanel">
                <div class="kt-notification">
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-line-chart kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New order has been received
                            </div>
                            <div class="kt-notification__item-time">
                                2 hrs ago
                            </div>
                        </div>
                    </a>
                </div>
            </div>

			<div class="tab-pane fade kt-scroll" id="v2" role="tabpanel">
				<div class="kt-notification-v2">
					<a href="#" class="kt-notification-v2__item">
						<div class="kt-notification-v2__item-icon">
							<i class="flaticon-bell kt-font-brand"></i>
						</div>
						<div class="kt-notification-v2__itek-wrapper">
							<div class="kt-notification-v2__item-title">
								5 new user generated report
							</div>
							<div class="kt-notification-v2__item-desc">
								Reports based on sales
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="tab-pane kt-quick-panel__content-padding-x fade kt-scroll" id="kt_quick_panel_tab_settings" role="tabpanel">
				<form class="kt-form">
					<div class="kt-heading kt-heading--sm kt-heading--space-sm">Customer Care</div>
					<div class="form-group form-group-xs row">
						<label class="col-8 col-form-label">Enable Notifications:</label>
						<div class="col-4 kt-align-right">
							<span class="kt-switch kt-switch--success kt-switch--sm">
								<label>
									<input type="checkbox" checked="checked" name="quick_panel_notifications_1">
									<span></span>
								</label>
							</span>
						</div>
					</div>
					<div class="form-group form-group-xs row">
						<label class="col-8 col-form-label">Enable Case Tracking:</label>
						<div class="col-4 kt-align-right">
							<span class="kt-switch kt-switch--success kt-switch--sm">
								<label>
									<input type="checkbox" name="quick_panel_notifications_2">
									<span></span>
								</label>
							</span>
						</div>
					</div>
					<div class="form-group form-group-last form-group-xs row">
						<label class="col-8 col-form-label">Support Portal:</label>
						<div class="col-4 kt-align-right">
							<span class="kt-switch kt-switch--success kt-switch--sm">
								<label>
									<input type="checkbox" checked="checked" name="quick_panel_notifications_2">
									<span></span>
								</label>
							</span>
						</div>
					</div>
					<div class="kt-separator kt-separator--space-md kt-separator--border-dashed"></div>
				</form>
			</div>
		</div>
	</div>
</div>