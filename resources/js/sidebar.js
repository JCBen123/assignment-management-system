const toggleBtn = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('sidebar');

if (toggleBtn && sidebar) {
    let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

    function updateCalendar() {
        setTimeout(() => {
            if (window.calendar) {
                window.calendar.updateSize();
            }
        }, 300);
    }

    function applySidebarState() {
        sidebar.classList.toggle('sidebar-collapsed', isCollapsed);

        document.documentElement.classList.remove('sidebar-initial-collapsed');

        updateCalendar();
    }

    applySidebarState();

    toggleBtn.addEventListener('click', () => {
        isCollapsed = !isCollapsed;

        sidebar.classList.toggle('sidebar-collapsed', isCollapsed);

        localStorage.setItem(
            'sidebarCollapsed',
            isCollapsed
        );

        updateCalendar();
    });
}
