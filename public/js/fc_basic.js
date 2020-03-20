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