import MaskBehaviors from './masks-behaviors'

$(function() {
    $('#cnpj').mask('00.000.000/0000-00');
    $('.cellphone-mask').mask(MaskBehaviors.nineDigitsBehavior, MaskBehaviors.nineDigitsOptions);
    $('.phone-mask').mask(MaskBehaviors.nineDigitsBehavior, MaskBehaviors.nineDigitsOptions);
    $('.money').mask("#.##0,00", {reverse: true});
});
