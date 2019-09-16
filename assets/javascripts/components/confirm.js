function showConfirm(title, message, callbackYes, callbackNo) {
    const modalAlert = $('#modal-confirm');
    modalAlert.find('.modal-title').html(title);
    modalAlert.find('.modal-message').html(message);

    modalAlert.find('#btn-yes').off('click');
    modalAlert.find('#btn-no').off('click');

    if (typeof callbackYes === "function") {
        modalAlert.find('#btn-yes').on('click', function (e) {
            callbackYes(e, modalAlert, $(this));
        });
    }

    if (typeof callbackNo === "function") {
        modalAlert.find('#btn-no').on('click', function (e) {
            callbackNo(e, modalAlert, $(this));
        });
    } else {
        modalAlert.find('#btn-no').on('click', function (e) {
            modalAlert.modal('hide');
        });
    }

    modalAlert.modal({
        backdrop: 'static',
        keyboard: false
    });
}

export default showConfirm