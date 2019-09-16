export default function() {
    const modalDelete = $('#modal-delete');
    const buttonDelete = modalDelete.find('[data-submit]');
    const buttonDismiss = modalDelete.find('[data-dismiss]');
    const form = modalDelete.find('form');

    buttonDelete.on('click', function () {
        form.submit();
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();

        form.attr('action', $(this).data('url') || $(this).attr('href'));
        form.find('[name=id]').val($(this).data('id'));
        modalDelete.find('.delete-title').text($(this).data('title'));
        modalDelete.find('.delete-label').text($(this).data('label'));
    });

    buttonDismiss.on('click', function () {
        form.attr('action', '#');
        form.find('[name=id]').val('');
        form.find('.delete-title').text('');
        form.find('.delete-label').text('');
    });
};