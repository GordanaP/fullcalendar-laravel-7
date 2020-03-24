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
        var eventStart = new Date(event.start_at);
        var eventEnd = new Date(event.end_at);
        var eventColor = event.color;
        var eventStatus = event.status;

        calendarEvent.setProp('backgroundColor', eventColor);
        calendarEvent.setProp('borderColor', eventColor);
        calendarEvent.setExtendedProp('status', eventStatus);
        calendarEvent.setDates(eventStart, eventEnd);
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
    event.title = event.patient.last_name;
    event.start = event.start_at;
    event.end = event.end_at;
    event.backgroundColor = event.color;
    event.borderColor = event.color;
    event.status = event.status;
    event.editable = event.is_editable;

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
    return fcEvent.extendedProps.status == 'pending';
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