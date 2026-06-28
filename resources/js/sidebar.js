const toggleCloseBtn = document.getElementById('sidebar-close');
const toggleOpenBtn = document.getElementById('sidebar-open');
const sidebar = document.getElementById('sidebar');
const title = document.querySelector('.sidebar-title');
const texts = document.querySelectorAll('.sidebar-text');

let isCollapsed = false;

function collapseSidebar() {
    sidebar.classList.replace('w-64', 'w-20');
    sidebar.classList.add('sidebar-collapsed');
    // title.classList.replace('h-30', 'h-20');

    toggleCloseBtn.classList.add('hidden');
    toggleOpenBtn.classList.remove('hidden');
    isCollapsed = true;

    texts.forEach(t => t.classList.add('hidden'));

    setTimeout(() => {
        if (window.calendar) window.calendar.updateSize();
    }, 300);
}

function expandSidebar() {
    sidebar.classList.replace('w-20', 'w-64');
    sidebar.classList.remove('sidebar-collapsed');

    // setTimeout(() => {
    //     title.classList.replace('opacity-0', 'opacity-100')
    // }, 150);

    toggleOpenBtn.classList.add('hidden');
    toggleCloseBtn.classList.remove('hidden');
    isCollapsed = false;

    setTimeout(() => {
        texts.forEach(t => t.classList.remove('hidden'));
    }, 100);

    setTimeout(() => {
        if (window.calendar) window.calendar.updateSize();
    }, 300);
}

toggleCloseBtn.addEventListener('click', collapseSidebar);
toggleOpenBtn.addEventListener('click', expandSidebar);
