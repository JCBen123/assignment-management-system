<div x-data="
    {
        selectedAssignment: {},
        init() {
            window.addEventListener('open-assignment', (e) => {
                this.selectedAssignment = e.detail;
            });
        }
    }"
>
    <flux:modal name="view-assignment" class="md:w-[32rem] bg-white dark:bg-gray-800">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" x-text="selectedAssignment?.subject || 'Subject'"></flux:heading>
                <div class="flex items-center gap-6">
                    <flux:text x-text="selectedAssignment?.title || 'Assignment Details'"></flux:text>

                    <span class="mt-1 inline-flex rounded-full px-2 py-1 text-xs font-medium"
                        :class="{
                            'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-200': selectedAssignment?.status === 'pending',
                            'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-200': selectedAssignment?.status === 'completed',
                            'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-200': selectedAssignment?.status === 'overdue',
                        }"
                        x-text="selectedAssignment?.status
                            ? selectedAssignment.status.charAt(0).toUpperCase() + selectedAssignment.status.slice(1)
                            : ''">
                    </span>
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div>
                    <flux:heading size="sm">Due Date</flux:heading>
                    <flux:text x-text="selectedAssignment?.deadline || ''"></flux:text>
                </div>

                <div>
                    <flux:heading size="sm">Remarks</flux:heading>
                    <flux:text x-text="selectedAssignment?.remarks || '-'"></flux:text>
                </div>
            </div>
        </div>
    </flux:modal>
</div>
