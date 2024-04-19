$(document).ready(function() {
    $('#search').on('keyup', function() {
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            data: { search: $(this).val() },
            success: function(data) {
                $('#table-body').html(data);

                // Reinitialize the modals.
                $('.edit-btn').each(function() {
                    var target = $(this).attr('data-bs-target');
                    var modal = new bootstrap.Modal(document.querySelector(target));
                    $(this).click(function() {
                        modal.show();
                    });
                });
            }
        });
    });
});