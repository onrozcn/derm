<?php
include('source/settings.php');
if (isset($_SESSION["requesturl"])) {
    $_SESSION["requesturl"] = $siteUrl;
}
?>
<!DOCTYPE html>
<html lang="tr">

	<!-- begin::Head -->
	<head>
        <?php require_once('includes/head-codes.php'); ?>

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="assets/css/pages/login.css" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
					<div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
						<div class="kt-login__wrapper">
							<div class="kt-login__container" style="align-items: flex-start;">
								<div class="kt-login__body">
									<div class="kt-login__logo">
										<a href="#">
											<img src="assets/media/logos/logo_inverse.svg">
										</a>
									</div>



                                    <div class="kt-login__signin" id="selectFirmBlock" style="display: none;">
                                        <div class="kt-login__head">
                                            <h3 class="kt-login__title">Firma Seçimi</h3>
                                        </div>
                                        <div class="kt-login__form" style="color: #000">
                                            <div id="selectFirmForm"></div>
                                            <br/>
                                            <div id="firmMessagePlaceHolder"></div>
                                        </div>
                                    </div>



									<div class="kt-login__signin" id="loginBlock">
										<div class="kt-login__head">
											<h3 class="kt-login__title">Oturum Aç</h3>
                                        </div>
										<div class="kt-login__form">
											<form class="kt-form" method="post" name="loginForm">
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Kullanıcı Adı" name="username" autocomplete="off">
												</div>
												<div class="form-group">
													<input class="form-control form-control-last" type="password" placeholder="Şifre" name="password">
												</div>
												<div class="kt-login__extra">
													<label class="kt-checkbox">
														<input type="checkbox" name="keepmesignedin"> Beni Hatırla
														<span></span>
													</label>
													<a href="javascript:;" id="kt_login_forgot">Şifremi Unuttum ?</a>
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate">Oturum Aç</button>
												</div>
                                                <div id="messagePlaceHolderSignIn"></div>
											</form>
										</div>
									</div>
									<div class="kt-login__signup">
										<div class="kt-login__head">
											<h3 class="kt-login__title">Kayıt Talep Formu</h3>
											<div class="kt-login__desc">Lütfen kayıt talep formunu doldurun</div>
										</div>
										<div class="kt-login__form">
											<form class="kt-form" action="">
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Ad & Soyad" name="fullname">
												</div>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
												</div>
												<div class="form-group">
													<input class="form-control" type="password" placeholder="Şifre" name="password">
												</div>
												<div class="form-group">
													<input class="form-control form-control-last" type="password" placeholder="Şifre Onay" name="rpassword">
												</div>
												<div class="kt-login__extra">
													<label class="kt-checkbox">
														<input type="checkbox" name="agree"> <a href="#">Kullanım Koşullarını</a> onaylıyorum.
														<span></span>
													</label>
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_signup_submit" class="btn btn-brand btn-pill btn-elevate">Talep Gönder</button>
													<button id="kt_login_signup_cancel" class="btn btn-outline-brand btn-pill">İptal</button>
												</div>
                                                <div id="messagePlaceHolderSignUp"></div>
											</form>
										</div>
									</div>
									<div class="kt-login__forgot">
										<div class="kt-login__head">
											<h3 class="kt-login__title">Şifrenizi mi Unuttunuz ?</h3>
											<div class="kt-login__desc">Şifrenizi sıfırlamak için email adresinizi girin:</div>
										</div>
										<div class="kt-login__form">
											<form class="kt-form" action="">
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_forgot_submit" class="btn btn-brand btn-pill btn-elevate">Talep Et</button>
													<button id="kt_login_forgot_cancel" class="btn btn-outline-brand btn-pill">İptal</button>
												</div>
                                                <div id="messagePlaceHolderForget"></div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="kt-login__account">
								<span class="kt-login__account-msg">
									<?= date("Y") == 2018 ? '2018' : '2018 - ' . date("Y") ?> &copy; dERM <?=$siteJsVersion?>
								</span>&nbsp;&nbsp;
                                <a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Kayıt Ol!</a>
							</div>
						</div>
					</div>
					<div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content" style="background-image: url(assets/media/bg/bg-login-1.jpg);">
						<div class="kt-login__section">
							<div class="kt-login__block">
								<h3 class="kt-login__title">dERM</h3>
								<div class="kt-login__desc">
                                    Enterprise Resource Planning
                                    <br>Kurumsal Kaynak Planlaması
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#716aca",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->

		<!--end::Page Scripts -->

        <script type="text/javascript">
            $('form[name=loginForm]').submit(function () {
                $('#messagePlaceHolderSignIn').html('<div class="alert alert-info m-alert m-alert--air m-alert--outline animated fadeIn" role="alert"><div class="m-loader m-loader--info" style="width: 30px; height: 10px; display: inline-block;"></div> Lütfen Bekleyiniz.</div>');
                $('#kt_login_signin_submit').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
                let formData = $(this).serialize();
                $.ajax({
                    dataType: "json",
                    type    : 'POST',
                    url     : '<?=$siteUrl?>actions/login.php',
                    data    : formData,
                    success : function (response) {
                        if (response !== '') {
                            $('#messagePlaceHolderSignIn').html('<div class="' + response.cclass + '"><p>' + response.message + '</p></div>');
                            $('#kt_login_signin_submit').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            if (response.result === 'ok') {
                                if (response.firmList.length > 0) {
                                    loginLoadFirmList(response.firmList);
                                }
                                else {
                                    redirectToHome();
                                }
                            }
                        }
                        else {
                            $('#messagePlaceHolderSignIn').html('<div class="note note-warning"><p>An error occurred. Please try again.</p></div>');
                        }
                    }
                });
                return false;
            });

            function loginLoadFirmList(firmList) {
                $('#firmMessagePlaceHolder').html('');
                $('#loginBlock').fadeOut(500).promise().done(function () {
                    $('#selectFirmBlock').fadeIn(500);
                });

               let firmListContent = '';

                firmList.forEach(function (firm) {
                    firmListContent += '<div class="card mb-3" style="max-width: 540px;" onclick="loginSelectFirm(' + firm['id'] + ');">';
                    firmListContent += '<div class="row no-gutters align-items-center">';
                    firmListContent += '<div class="col-md-4 p-md-2 p-5">';
                    firmListContent += '<img src="' + firm['logo'] + '" class="card-img img-fluid">';
                    firmListContent += '</div>';
                    firmListContent += '<div class="col-md-8">';
                    firmListContent += '<div class="card-body text-center">';
                    // firmListContent += '<h5 class="card-title">' + firm['tag'] + '</h5>';
                    firmListContent += '<p class="card-text">' + firm['unvan'] + '</p>';
                    //firmListContent += '<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>';
                    firmListContent += '</div>';
                    firmListContent += '</div>';
                    firmListContent += '</div>';
                    firmListContent += '</div>';
                });


                firmListContent += '</div>';
                $('#selectFirmForm').html(firmListContent);
            }

            function loginSelectFirm(firmId) {
                $('#firmMessagePlaceHolder').html('<div class="note note-info"><p>Lütfen bekleyin...</p></div>');
                $.ajax({
                    dataType: "json",
                    type    : 'POST',
                    url     : '<?=$siteUrl?>actions/login-firm.php',
                    data    : {
                        firmId
                    },
                    success : function (response) {
                        if (response !== '') {
                            $('#firmMessagePlaceHolder').html(response.message);
                            if (response.result === 'ok') {
                                redirectToHome();
                            }
                        }
                        else {
                            $('#firmMessagePlaceHolder').html('<div class="note note-warning"><p>An error occurred. Please try again.</p></div>');
                        }
                    }
                });
                return false;
            }

            function redirectToHome() {
                setTimeout(function () {
                    window.location.href = '<?=isset($_SESSION["requesturl"]) ? $_SESSION["requesturl"] : 'index.php'?>';
                }, 2000);
            }


            // Private Functions
            var displaySignUpForm = function() {
                login.removeClass('kt-login--forgot');
                login.removeClass('kt-login--signin');

                login.addClass('kt-login--signup');
                KTUtil.animateClass(login.find('.kt-login__signup')[0], 'flipInX animated');
            }

            var displaySignInForm = function() {
                login.removeClass('kt-login--forgot');
                login.removeClass('kt-login--signup');

                login.addClass('kt-login--signin');
                KTUtil.animateClass(login.find('.kt-login__signin')[0], 'flipInX animated');
                //login.find('.kt-login__signin').animateClass('flipInX animated');
            }

            var displayForgotForm = function() {
                login.removeClass('kt-login--signin');
                login.removeClass('kt-login--signup');

                login.addClass('kt-login--forgot');
                //login.find('.kt-login--forgot').animateClass('flipInX animated');
                KTUtil.animateClass(login.find('.kt-login__forgot')[0], 'flipInX animated');

            }

            var handleFormSwitch = function() {
                $('#kt_login_forgot').click(function(e) {
                    e.preventDefault();
                    displayForgotForm();
                });

                $('#kt_login_forgot_cancel').click(function(e) {
                    e.preventDefault();
                    displaySignInForm();
                });

                $('#kt_login_signup').click(function(e) {
                    e.preventDefault();
                    displaySignUpForm();
                });

                $('#kt_login_signup_cancel').click(function(e) {
                    e.preventDefault();
                    displaySignInForm();
                });
            }




            var KTLoginGeneral = function() {

                var login = $('#kt_login');

                // Private Functions
                var displaySignUpForm = function() {
                    login.removeClass('kt-login--forgot');
                    login.removeClass('kt-login--signin');

                    login.addClass('kt-login--signup');
                    KTUtil.animateClass(login.find('.kt-login__signup')[0], 'flipInX animated');
                }

                var displaySignInForm = function() {
                    login.removeClass('kt-login--forgot');
                    login.removeClass('kt-login--signup');

                    login.addClass('kt-login--signin');
                    KTUtil.animateClass(login.find('.kt-login__signin')[0], 'flipInX animated');
                    //login.find('.kt-login__signin').animateClass('flipInX animated');
                }

                var displayForgotForm = function() {
                    login.removeClass('kt-login--signin');
                    login.removeClass('kt-login--signup');

                    login.addClass('kt-login--forgot');
                    //login.find('.kt-login--forgot').animateClass('flipInX animated');
                    KTUtil.animateClass(login.find('.kt-login__forgot')[0], 'flipInX animated');

                }

                var handleFormSwitch = function() {
                    $('#kt_login_forgot').click(function(e) {
                        e.preventDefault();
                        displayForgotForm();
                    });

                    $('#kt_login_forgot_cancel').click(function(e) {
                        e.preventDefault();
                        displaySignInForm();
                    });

                    $('#kt_login_signup').click(function(e) {
                        e.preventDefault();
                        displaySignUpForm();
                    });

                    $('#kt_login_signup_cancel').click(function(e) {
                        e.preventDefault();
                        displaySignInForm();
                    });
                }

                // Public Functions
                return {
                    // public functions
                    init: function() {
                        handleFormSwitch();
                    }
                };
            }();

            // Class Initialization
            jQuery(document).ready(function() {
                KTLoginGeneral.init();
            });

        </script>

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->
	</body>
	<!-- end::Body -->
</html>