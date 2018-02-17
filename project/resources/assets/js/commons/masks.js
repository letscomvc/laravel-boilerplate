import MaskBehaviors from './masks-behaviors'

$(function() {
    $('.cnpj-mask').mask('00.000.000/0000-00');
    $('.phone-mask').mask(MaskBehaviors.nineDigitsBehavior, MaskBehaviors.nineDigitsOptions);
});
