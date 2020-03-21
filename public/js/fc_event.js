/**
 * Remove the event from the calendar.
 *
 * @param integer eventId
 * @param FullCalendar calendar
 */
function removeCalendarEvent(eventId, calendar)
{
    calendar.getEventById(eventId).remove();
}

/**
 * Update the event in the calendar.
 *
 * @param JSONfeed event
 * @param FullCalendar calendar
 */
function updateCalendarEvent(event, calendar)
{
    if(event) {
        var calendarEvent = calendar.getEventById(event.id);
        var newStart = new Date(event.start_at);
        var newEnd = new Date(event.end_at);

        calendarEvent.setExtendedProp('outcome', event.outcome);
        calendarEvent.setDates(newStart, newEnd);
    }
}

/**
 * Add the event to the calendar.
 *
 * @param JSONfeed event
 * @param FullCalendar calendar
 * @param string eventSourceId
 */
function addCalendarEvent(event, calendar, eventSourceId = 'jsonFeedUrl')
{
    var eventObj = transformToEventObj(event);
    var eventSource = calendar.getEventSourceById(eventSourceId);

    calendar.addEvent( eventObj, eventSource);
}

/**
 * Transform to event object.
 *
 * @param  JSONfeed event
 * @return FullCalendar\EventObj
 */
function transformToEventObj(event) {
    event.title = event.title;
    event.start = event.start_at;
    event.end = event.end_at;
    event.outcome = event.outcome;

    return event;
}

/**
 * Determine if the event is pending.
 *
 * @param  FullCalendar\EventObj  fcEvent
 * @return boolean
 */
function isPending(fcEvent)
{
    return fcEvent.extendedProps.outcome == 'pending';
}

/**
 * Determine if the event start is past.
 *
 * @param  mixed eventStart
 * @return boolean
 */
function isPast(eventStart)
{
    var start = moment(eventStart);
    var now = moment(new Date());

    return start.diff(now, 'minutes') < 0;
}

/**
 * Toggle the event related hidden elements presence.
 *
 * @param  FullCalendar\EventObj fcEvent
 * @param  JQuery\Obj eventDeleteBtn
 * @param  JQuery\Obj eventOutcomeDiv
 */
function toggleEventRelatedHiddenElems(fcEvent, eventDeleteBtn, eventOutcomeDiv)
{
    if(isPast(fcEvent.start)) {
        eventDeleteBtn.hide();
        eventOutcomeDiv.show();
    } else {
        eventDeleteBtn.val(fcEvent.id).show();
        eventOutcomeDiv.hide();
    }
}