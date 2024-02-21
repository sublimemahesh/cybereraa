// import the third-party stylesheets directly from your JS
import {Calendar} from '@fullcalendar/core';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import rrulePlugin from '@fullcalendar/rrule'

window.FullCalendar = {
    Calendar,
    plugins: {
        dayGridPlugin,
        timeGridPlugin,
        listPlugin,
        rrulePlugin,
        interactionPlugin,
        bootstrap5Plugin,
    },
    calendarEl: document.querySelector("#calendarEl") || false,
    defaultOptions: {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, bootstrap5Plugin],
        initialView: window.innerWidth < 768 ? "timeGridDay" : "dayGridMonth",
        selectable: true,
        nowIndicator: true,
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        dayMaxEventRows: true, // for all non-TimeGrid views
        views: {
            dayGridMonth: {
                dayMaxEventRows: 4
            },
            timeGrid: {
                dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
            }
        },
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        themeSystem: 'bootstrap5',
        contentHeight: 820,
    },
    init: function (calendarEl = this.calendarEl, optionOverrides = {}) {
        return calendarEl && new Calendar(calendarEl, {
            ...this.defaultOptions,
            ...optionOverrides
        });
    },
};
