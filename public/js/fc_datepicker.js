/**
 * Highlight the doctor's office days.
 *
 * @param  Javascript\Date date
 * @param  array doctorAbsences
 * @param  array doctorOfficeDays
 * @param  string holidayClass
 * @param  string absenceClass
 * @return array
 */
function markDoctorOfficeDays(date, doctorOfficeDays, doctorAbsences, holidayClass="holiday", absenceClass="absence")
{
    var formattedDate = jQuery.datepicker.formatDate('yy-mm-dd', date);

    if (isSunday(date) || isHoliday(date)) {
        return [false, holidayClass];
    } else if (isDoctorAbsenceDate(formattedDate, doctorAbsences)) {
        return [false, absenceClass];
    } else if (! isDoctorOfficeDay(date, doctorOfficeDays)) {
        return [false, "", ""];
    } else {
        return [true];
    }
}