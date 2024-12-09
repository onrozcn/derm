<script type="text/javascript">
    AracGirisCikisWidget();
    function AracGirisCikisWidget() {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: siteUrl + 'actions/widgets.php?Action=AracGirisCikisWidget',
            success: function (response) {
                $('#chart-container-aracgiriscikis').html(response);
            },
            error: function () {
                alert('An error occurred, please try again later.')
            }
        });
    }
</script>



