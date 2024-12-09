$(document).ready(function () {
	LoadParameters();
});




$("#search").keyup(function () {
	var value = this.value.toLowerCase().trim();

	$("table tr").each(function (index) {
		if (!index) return;
		$(this).find("td").each(function () {
			var id = $(this).text().toLowerCase().trim();
			var not_found = (id.indexOf(value) == -1);
			$(this).closest('tr').toggle(!not_found);
			return not_found;
		});
	});
});



function LoadParameters() {
	var cat = $('#cat').val();
	var parameter = $('#parameter').val();
	var mode = $('#mode').val();
	if (cat != null && cat != '' && parameter != null && parameter != '') {
		$.ajax({
			type   : 'POST',
			url    : siteUrl + 'actions/parameter.php?Action=ParameterList',
			data   : {
				'cat': cat,
				'parameter': parameter,
				'mode': mode
			},
			success: function (response) {
				if (response != '') {
					$('#ParameterList').html(response);
				}
			}
		});
	}
}

function LoadParameterData(id) {
	var cat = $('#cat').val();
	var parameter = $('#parameter').val();
	if (parameter != null && parameter != '') {
		$.ajax({
			dataType: 'json',
			type    : 'POST',
			url     : siteUrl + 'actions/parameter.php?Action=LoadParameterData',
			data    : {
				'cat': cat,
				'parameter': parameter,
				'id'       : id
			},
			success : function (data) {
				$('#parametertitletext').html(data.parametertitle);
				$.each(data, function (k, v) {
					// alert(k + ' ' + v);
					if ($('#PF' + k).length > 0) {
						$('#PF' + k).val(v);
					}
				});
				$('#parametermodal').modal('show');
			}
		});
	}
}

function NewParameterData() {
	ResetParameterData();
	var parametertitle = $('#parametertitlevalue').val();
	$('#parametertitletext').html(parametertitle);
	$('#parametermodal').modal('show');
}

function ResetParameterData() {
	$('form[name=ParameterForm]').find('input').each(function () {
		$(this).val('');
	});
	$('form[name=ParameterForm]').find('select').each(function () {
		$(this).val('0');
	});
	$('form[name=ParameterForm]').find('textarea').each(function () {
		$(this).val('');
	});
	$('#parametertitlevalue').html('');
	$('#PFid').val('0');
}

function DeleteParameter(id) {
	if (confirm('Are you sure want to delete this parameter? You can\'t undo this process later.')) {
		var cat = $('#cat').val();
		var parameter = $('#parameter').val();
		$.ajax({
			type    : 'POST',
			dataType: 'json',
			url     : siteUrl + 'actions/parameter.php?Action=DeleteParameter',
			data    : {
				'cat': cat,
				'parameter': parameter,
				'id'       : id
			},
			success : function (response) {
				if (response.result == 'ok') {
					LoadParameters();
				}
				if (response.message != '') {
					alert(response.message);
				}
			},
			error   : function () {
				alert('An error occurred, please try again later.')
			}
		});
	}
}

function SwitchModeParameter(id, currentmode) {
	swal.fire({
		title: "Parametrenin modunu değiştirmek istediğinize emin misiniz?",
		text: "",
		type: "question",
		buttonsStyling: false,
		confirmButtonText: "<i class='la la-retweet'></i> Evet, Değiştir!",
		confirmButtonClass: "btn btn-danger",
		showCancelButton: true,
		cancelButtonText: "<i class='fal fa-times-circle'></i> İptal",
		cancelButtonClass: "btn btn-default"
	}).then((result) => {
		if (result.value) {
			var cat = $('#cat').val();
			var parameter = $('#parameter').val();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: siteUrl + 'actions/parameter.php?Action=SwitchModeParameter',
				data: {
					'cat': cat,
					'parameter': parameter,
					'id': id,
					'currentmode': currentmode
				},
				success: function (response) {
					if (response.result == 'ok') {
						LoadParameters();
						toastr[response.notifyType](response.notifyMessage, response.notifyTitle);
					}
					if (response.message != '' && response.result != 'ok') {
						toastr.error(response.message, 'Hata');
					}
				},
				error: function () {
					alert('An error occurred, please try again later.')
				}
			});
		}
	})
}

$('form[name=ParameterForm]').submit(function () {
	var form = $(this);
	var formvalues = $(this).serializeArray();
	formvalues.push({
		name : 'cat',
		value: $('#cat').val()
	});
	formvalues.push({
		name : 'parameter',
		value: $('#parameter').val()
	});
	formvalues = $.param(formvalues);
	$.ajax({
		type    : 'POST',
		dataType: 'json',
		url     : form.attr('action'),
		data    : formvalues,
		success : function (response) {
			if (response.result == 'ok') {
				$('#PFid').val(response.id);
				LoadParameters();
				$('#parametermodal').modal('hide');
			}

			toastr[response.notifyType](response.notifyMessage, response.notifyTitle);

		},
		error   : function () {
			toastr.error('Hata oluştu lütfen tekrar deneyin', 'Hata');
		}
	});
	return false;
});

function ParameterOrderChange(id, direction) {
	var cat = $('#cat').val();
	var parameter = $('#parameter').val();
	$.ajax({
		type    : 'POST',
		dataType: 'json',
		url     : siteUrl + 'actions/parameter.php?Action=ParameterOrderChange',
		data    : {
			'id'       : id,
			'cat': cat,
			'parameter': parameter,
			'direction': direction
		},
		success : function (response) {
			if (response.result == 'ok') {
				LoadParameters();
				toastr[response.notifyType](response.notifyMessage, response.notifyTitle);
			}
			if (response.message != '' && response.result != 'ok') {
				toastr.error(response.message, 'Hata');
			}
		},
		error   : function () {
			toastr.error('Hata oluştu lütfen tekrar deneyin', 'Hata');
		}
	});
}