/**
 * View dependent event time.
 *
 * @param  FullCalendar\Object
 * @param  string businessOpen
 * @return string
 */
function viewDependentEventTime(selectInfo, businessOpen)
{
    var selected = selectInfo.start;
    var formattedSelected = formatDate(selected, 'HH:mm');
    var formattedBusiness = formatDateString(businessOpen, 'HH:mm:ss', 'HH:mm');

    return selectInfo.view.viewSpec.type == "dayGridMonth"
        ? formattedBusiness : formattedSelected;
}

/**
 * Determine if the given date can be selected.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isSelectable(date, doctorAbsences)
{
    return  ! isPast(date) &&
            ! isSunday(date) &&
            ! isHoliday(date) &&
            ! isDoctorAbsenceDate(date, doctorAbsences);
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
 * Format the date string.
 *
 * @param  string dateString
 * @param  string stringFormat
 * @param  string newFormat
 * @return string
 */
function formatDateString(dateString, stringFormat, newFormat)
{
    return moment(dateString, stringFormat).format(newFormat);
}

/**
 * The date time string.
 *
 * @param  string date
 * @param  string time
 * @return string
 */
function dateTimeString(date, time)
{
    return date + ' ' + time;
}