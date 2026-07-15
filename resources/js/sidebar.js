const toggleBtn = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('sidebar');
const texts = document.querySelectorAll('.sidebar-text');

let isCollapsed = false;

function collapseSidebar() {
    sidebar.classList.replace('w-64', 'w-24');
    sidebar.classList.add('sidebar-collapsed');
    isCollapsed = true;

    texts.forEach(t => {
        t.classList.add('opacity-0', 'w-0', 'overflow-hidden');
    });

    setTimeout(() => {
        if (window.calendar) window.calendar.updateSize();
    }, 300);
}

function expandSidebar() {
    sidebar.classList.replace('w-24', 'w-64');
    sidebar.classList.remove('sidebar-collapsed');
    isCollapsed = false;

    setTimeout(() => {
        texts.forEach(t => {
            t.classList.remove('opacity-0', 'w-0', 'overflow-hidden');
        });
    }, 100);

    setTimeout(() => {
        if (window.calendar) window.calendar.updateSize();
    }, 300);
}

toggleBtn.addEventListener('click', () => {
    if (isCollapsed) {
        expandSidebar();
    } else {
        collapseSidebar();
    }
});
