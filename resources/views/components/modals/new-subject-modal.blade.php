<div id="new-subject-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 opacity-0 transition-opacity duration-300 ease-in-out">
    <div id="new-subject-panel" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800 scale-95 opacity-0 transition-all duration-300 ease-in-out">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Subject</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Create a new subject and start organizing assignments.</p>
            </div>
        </div>

        <form class="mt-6 space-y-4">
            <div>
                <label for="subject-name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Subject Name</label>
                <input id="subject-name" type="text" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="e.g. Literature">
            </div>

            <div>
                <label for="subject-code" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Subject Code</label>
                <input id="subject-code" type="text" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="e.g. LIT301">
            </div>

            <div>
                <label for="remarks" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Additional Remarks</label>
                <textarea id="remarks" rows="4" class="w-full rounded-lg resize-none border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="e.g. Advanced Literature"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="close-subject-modal" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                    Cancel
                </button>

                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const open = document.getElementById('new-subject');
    const close = document.getElementById('close-subject-modal');
    const modal = document.getElementById('new-subject-modal');
    const panel = document.getElementById('new-subject-panel');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');

            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');

        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    open.addEventListener('click', openModal);
    close.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
</script>
