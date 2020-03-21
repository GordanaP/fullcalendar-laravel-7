/**
 * Format the Javascript date object.
 *
 * @param  Javascript\Date Object date
 * @param  string format
 * @return string
 */
function formatDate(date, format)
{
    return moment(date).format(format);
}


/**
 * Determine if the given date can be selected.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isSelectable(date)
{
    return  ! isPast(date);
}