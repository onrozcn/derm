function activeUser(id) {
	swal.fire({
		title: 'Emin misiniz?',
		text: 'Bu kullanıcıyı pasif yapıyorsunuz.',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Evet',
		cancelButtonText: 'Hayır'
	}).then((result) => {
		if (result.value) {
			/* BEGIN ::TRUE */
			$.ajax({
				type    : 'POST',
				dataType: 'json',
				url     : siteUrl + 'actions/user-list.php?Action=inactiveUser',
				data    : {
					'id': id
				},
				success : function (response) {
					if (response.result != '') {
						if (response.result == 'reload' || response.result == 'ok') {
							$('#userProfile-' + id).remove();
							toastr.success('Kullanıcının statusü değiştirildi', 'Başarılı');
						}
						else {
							alert('Veri gonderilerken hata olustu');
						}
					}
				},
				error   : function () {
					alert('Veri gonderilerken hata olustu');
				}
			});
			/* END ::TRUE */
		} else {
			/* BEGIN ::FALSE */
			toastr.warning('İşlem iptal edildi', 'İptal');
			/* END ::FALSE */
		}
	})
}

function inactiveUser(id) {
	swal.fire({
		title: 'Emin misiniz?',
		text: 'Bu kullanıcıyı aktif yapıyorsunuz.',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Evet',
		cancelButtonText: 'Hayır'
	}).then((result) => {
		if (result.value) {
			/* BEGIN ::TRUE */
			$.ajax({
				type    : 'POST',
				dataType: 'json',
				url     : siteUrl + 'actions/user-list.php?Action=activeUser',
				data    : {
					'id': id
				},
				success : function (response) {
					if (response.result != '') {
						if (response.result == 'reload' || response.result == 'ok') {
							$('#userProfile-' + id).remove();
							toastr.success('Kullanıcının statusü değiştirildi', 'Başarılı');
						}
						else {
							alert('Veri gonderilerken hata olustu');
						}
					}
				},
				error   : function () {
					alert('Veri gonderilerken hata olustu');
				}
			});
			/* END ::TRUE */
		} else {
			/* BEGIN ::FALSE */
			toastr.warning('İşlem iptal edildi', 'İptal');
			/* END ::FALSE */
		}
	})
}