<flux:modal name="view-assignment" class="md:w-[32rem] bg-white dark:bg-gray-800">
    <div class="space-y-6">
        <div class="flex items-center gap-6">
                <flux:heading size="lg" x-text="selectedAssignment?.title || 'Assignment Details'"></flux:heading>
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

        <div class="pt-4 border-t border-gray-200 dark:border-gray-700" x-show="selectedAssignment?.status?.toLowerCase() !== 'completed'">
            <form method="POST" action="{{ route('assignments.markAsCompleted') }}">
                @csrf

                <input type="hidden" name="id" :value="selectedAssignment?.id">

                <flux:button type="submit" variant="primary" class="w-full cursor-pointer text-white bg-green-700 hover:bg-green-500">
                    Mark as Completed
                </flux:button>
            </form>
        </div>
    </div>
</flux:modal>
