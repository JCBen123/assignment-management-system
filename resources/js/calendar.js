import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar')
    if (!calendarEl) return

    window.calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        height: '100%',
        headerToolbar: {
            left: 'prev today',
            center: 'title',
            right: 'next'
        },
        buttonText: { today: 'Today' },
        selectable: true,
        events: [
            { title: 'Meeting', start: '2026-03-05' },
            { title: 'Demo Event', start: '2026-04-04' }
        ]
    })

    window.calendar.render()

    window.addEventListener('resize', () => window.calendar.updateSize())
})
