/**
 * Check the radio button.
 *
 * @param  JQuery\Object radio
 * @param  string optionValue
 */
function checkRadioOption(radio, optionValue)
{
    radio.filter('[value='+optionValue+']').prop('checked', true);
}