function BackupAdd(type=1) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/backup.php?Action=BackupAdd',
        data: {
            'type': type
        },
        success: function (response) {
            if (response.result == 'ok') {
                toastr.success(response.message, 'Başarılı');
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                toastr.error('', 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}

function BackupRemove(type, file) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/backup.php?Action=BackupRemove',
        data: {
            'type': type,
            'file': file
        },
        success: function (response) {
            if (response.result == 'ok') {
                toastr.success(response.message, 'Başarılı');
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                toastr.error('', 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}
