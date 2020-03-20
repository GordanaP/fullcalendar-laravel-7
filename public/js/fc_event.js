/**
 * Add the event to the calendar.
 *
 * @param FullCalendar\EventObject event
 * @param Fullcalendar calendar
 * @param string eventSourceId
 */
function addCalendarEvent(event, calendar, eventSourceId = 'jsonFeedUrl')
{
    var eventSource = calendar.getEventSourceById(eventSourceId);

    calendar.addEvent( event, eventSource);
}

/**
 * Update the event in the calendar.
 *
 * @param FullCalendar\EventObject event
 * @param Fullcalendar calendar
 */
function updateCalendarEvent(event, calendar)
{
    var title = event.title;
    var start = new Date(event.start);
    var end = new Date(event.end);
    var calendarEvent = calendar.getEventById(event.id);

    calendarEvent.setProp('title', title);
    calendarEvent.setDates(start, end);
}

/**
 * Remove the event from the calendar.
 *
 * @param FullCalendar\EventObject event
 * @param Fullcalendar calendar
 */
function removeCalendarEvent(eventId, calendar)
{
    calendar.getEventById(eventId).remove();
}