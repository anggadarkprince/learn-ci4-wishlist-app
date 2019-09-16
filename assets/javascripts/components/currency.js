export default {
    setCurrencyValue: function (value, prefix) {
        var number_string = value.toString().replace(/[^,\d]/g, '').toString(),
            splitDecimal = number_string.split(','),
            groupThousand = splitDecimal[0].length % 3,
            currency = splitDecimal[0].substr(0, groupThousand),
            thousands = splitDecimal[0].substr(groupThousand).match(/\d{3}/gi);
        if (thousands) {
            var separator = groupThousand ? '.' : '';
            currency += separator + thousands.join('.');
        }
        currency = splitDecimal[1] != undefined ? currency + ',' + splitDecimal[1] : currency;
        return prefix + currency;
    },

    getCurrencyValue: function (value) {
        return value.toString().replace(/[^0-9\,]/g, '').replace(/,/, '.');
    }
};
