<flux:modal name="view-assignment" class="md:w-[32rem] bg-white dark:bg-gray-800">
    <div class="space-y-6">
        <div class="flex items-start justify-between gap-3">
            <div>
                <flux:heading size="lg" x-text="selectedAssignment?.title || 'Assignment Details'"></flux:heading>

                <flux:text class="mt-1" x-text="selectedAssignment?.status || ''"></flux:text>
            </div>
        </div>

        <div class="space-y-4 text-sm">
            <div>
                <flux:heading size="sm">Due Date</flux:heading>
                <flux:text x-text="selectedAssignment?.due || ''"></flux:text>
            </div>

            <div>
                <flux:heading size="sm">Description</flux:heading>
                <flux:text x-text="selectedAssignment?.description || ''"></flux:text>
            </div>
        </div>
    </div>
</flux:modal>
