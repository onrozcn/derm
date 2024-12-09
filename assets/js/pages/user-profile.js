var BootstrapDatepicker = {
	init: function() {
		$("#birthdayDate").datepicker({
			//orientation: "bottom left",
			language: 'tr',
			todayBtn: "linked",
			clearBtn: !0,
			todayHighlight: !0,
			templates: {
				leftArrow: '<i class="la la-angle-left"></i>',
				rightArrow: '<i class="la la-angle-right"></i>'
			}
		})
	}
};

jQuery(document).ready(function() {
	BootstrapDatepicker.init()
});



$('form[name=userProfile]').submit(function () {
	var form = $(this);
	$.ajax({
		type    : 'POST',
		dataType: 'json',
		url     : siteUrl + 'actions/user-profile.php?Action=userProfile',
		data    : form.serialize(),
		success : function (response) {
			if (response.result != '') {
				if (response.result == 'empty') {
					toastr.warning(response.message, 'Uyarı');
				}
				if (response.result == 'ok') {
					toastr.success(response.message, 'Başarılı');
				}
				if (response.result == 'duplicate') {
					toastr.warning(response.message, 'Tekrarlanan Veri');
				}
				if (response.result == 'fail') {
					toastr.error(response.message, 'Hata');
				}
			}
			else {
				toastr.error('Veri gönderilirken hata oluştu', 'Hata');
			}
		},
		error   : function () {
			toastr.error('Veri gönderilirken hata oluştu', 'Hata');
		}
	});
	return false;
});

$('form[name=userPassword]').submit(function () {
	var form = $(this);
	$.ajax({
		type    : 'POST',
		dataType: 'json',
		url     : siteUrl + 'actions/user-profile.php?Action=userPassword',
		data    : form.serialize(),
		success : function (response) {
			if (response.result != '') {
				if (response.result == 'empty') {
					toastr.warning(response.message, 'Uyarı');
				}
				if (response.result == 'notmatch') {
					toastr.warning(response.message, 'Uyarı');
				}
				if (response.result == 'ok') {
					toastr.success(response.message, 'Başarılı');
				}
			}
			else {
				toastr.error('Veri gönderilirken hata oluştu', 'Hata');
			}
		},
		error   : function () {
			toastr.error('Veri gönderilirken hata oluştu', 'Hata');
		}
	});
	return false;
});

$('form[name=userPermissions]').submit(function () {
	var form = $(this);
	$.ajax({
		type    : 'POST',
		dataType: 'json',
		url     : siteUrl + 'actions/user-profile.php?Action=userPermissions',
		data    : form.serialize(),
		success : function (response) {
			if (response.result != '') {
				if (response.result == 'empty') {
					toastr.warning(response.message, 'Uyarı');
				}
				if (response.result == 'fail') {
					toastr.error(response.message, 'Hata');
				}
				if (response.result == 'ok') {
					toastr.success(response.message, 'Başarılı');
				}
			}
			else {
				toastr.error('Veri gönderilirken hata oluştu', 'Hata');
			}
		},
		error   : function () {
			toastr.error('Veri gönderilirken hata oluştu', 'Hata');
		}
	});
	return false;
});

$('form[name=userFirmPermissions]').submit(function () {
	var form = $(this);
	$.ajax({
		type    : 'POST',
		dataType: 'json',
		url     : siteUrl + 'actions/user-profile.php?Action=userFirmPermissions',
		data    : form.serialize(),
		success : function (response) {
			if (response.result != '') {
				if (response.result == 'empty') {
					toastr.warning(response.message, 'Uyarı');
				}
				if (response.result == 'fail') {
					toastr.error(response.message, 'Hata');
				}
				if (response.result == 'ok') {
					toastr.success(response.message, 'Başarılı');
				}
			}
			else {
				toastr.error('Veri gönderilirken hata oluştu', 'Hata');
			}
		},
		error   : function () {
			toastr.error('Veri gönderilirken hata oluştu', 'Hata');
		}
	});
	return false;
});


var DropzoneDemo = {
	init: function() {
		Dropzone.options.mDropzoneOne = {
			paramName: "file",
			maxFiles: 1,
			maxFilesize: 5,
			addRemoveLinks: !0,
			accept: function(e, o) { "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o() }
		},
		Dropzone.options.mDropzoneTwo = {
			paramName: "file",
			maxFiles: 10,
			maxFilesize: 10,
			addRemoveLinks: !0,
			accept: function(e, o) { "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o() }
		},
		Dropzone.options.mDropzoneThree = {
			paramName: "file",
			maxFiles: 10,
			maxFilesize: 10,
			addRemoveLinks: !0,
			acceptedFiles: "image/*,application/pdf,.psd",
			accept: function(e, o) { "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o() }
		}
	}
};
DropzoneDemo.init();