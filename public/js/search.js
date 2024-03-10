$(document).ready(function() {
    $('#search').on('keyup', function() {
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            data: { search: $(this).val() },
            success: function(data) {
                $('#table-body').html(data);
            }
        });
    });
});