const nineDigitsBehavior = function (val) {
    if (val.replace(/\D/g, '').length === 11) {
        return '(00) 00000-0000'
    }

    return '(00) 0000-00009';
};

const nineDigitsOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(nineDigitsBehavior.apply({}, arguments), options);
    }
};

export default {
    nineDigitsBehavior,
    nineDigitsOptions,
}
