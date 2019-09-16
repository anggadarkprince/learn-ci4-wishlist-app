// One touch on submit
function checkOnTouchSubmit(form) {
    const buttonSubmit = $(form).find('[data-toggle=one-touch]');
    if (buttonSubmit.length) {
        let message = buttonSubmit.data('touch-message');
        if (message === undefined) {
            message = 'Submitted...';
        }
        buttonSubmit.attr('disabled', true).html(message);
    }
}

$('form').on('submit', function (e) {
    if ($(this).attr('novalidate') !== undefined) {
        if ($(this).valid()) {
            checkOnTouchSubmit($(this));
        }
    }
    return true;
});