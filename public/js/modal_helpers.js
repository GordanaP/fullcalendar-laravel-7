/**
 * Reset the modal content upon close.
 *
 * @param  array errors
 * @param  array hiddenElems
 */
$.fn.clearContentOnClose = function(hiddenElems)
{
    $(this).on("hidden.bs.modal", function() {
        $(this).clearFormContent();
        $(this).hideElements(hiddenElems, $(this));
    });
}

/**
 * Remove all errors.
 *
 * @param  array errors
 */
$.fn.clearAllErrors = function(errors)
{
     $.each(errors, function (index, error) {
        clearError(error);
    });
}

/**
 * Clear the form content.
 */
$.fn.clearFormContent = function()
{
    $(this).find('form').trigger('reset');
}

/**
 * Hide elements.
 *
 * @param  array elements
 * @param  JQuery\Object modal
 */
$.fn.hideElements = function(hiddenElems, modal)
{
    hiddenElems.map(function(elem) {
        modal.find(elem).hide();
    });
}

/**
 * The modal autofocus field.
 *
 * @param string elementId
 */
$.fn.autofocus = function(elementId) {
    $(this).on('shown.bs.modal', function () {
        $(this).find(elementId).focus();
    });
}

/**
 * Close the modal.
 */
$.fn.close = function()
{
    $(this).modal('hide');
}

/**
 * Open the modal.
 */
$.fn.open = function()
{
    $(this).modal('show');
}
