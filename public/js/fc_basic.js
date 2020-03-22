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
    return  ! isPast(date) &&
            ! isHoliday(date);
}

/**
 * Determine if the given date is Sunday.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isSunday(date)
{
    return date.getDay() == 0;
}

/**
 * Determine if the date is past.
 *
 * @param  mixed dateTime
 * @return boolean
 */
function isPast(dateTime)
{
    var date = moment(dateTime);
    var now = moment(new Date());

    return date.diff(now, 'minutes') < 0;
}