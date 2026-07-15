import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar')
    if (!calendarEl) return

    const events = window.assignmentScheduleEvents ?? []

    window.calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev today',
            center: 'title',
            right: 'next'
        },
        buttonText: { today: 'Today' },
        selectable: true,
        events,

        // Calendar Events
        eventContent(info) {
            const el = document.createElement('div');

            el.className = 'overflow-hidden cursor-pointer';

            el.innerHTML = `
                <div class="font-bold truncate">
                    ${info.event.extendedProps.subject_name}
                </div>
                <div class="truncate">
                    ${info.event.title}
                </div>
            `;

            el.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('open-assignment', {
                    detail: {
                        id: info.event.extendedProps.id,
                        title: info.event.title,
                        subject: info.event.extendedProps.subject_name,
                        deadline: info.event.extendedProps.deadline,
                        status: info.event.extendedProps.status,
                        remarks: info.event.extendedProps.remarks,
                    }
                }));

                window.Flux?.modal?.('view-assignment')?.show();
            });

            return {
                domNodes: [el]
            };
        }
    })

    window.calendar.render()

    window.addEventListener('resize', () => window.calendar.updateSize())
})
