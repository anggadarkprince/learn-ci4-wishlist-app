import formatter from '../components/formatter';

// Currency text
$(document).on('keyup', '.currency', function () {
    const value = $(this).val();
    $(this).val(formatter.setNumberValue(value, 'Rp. '));
});