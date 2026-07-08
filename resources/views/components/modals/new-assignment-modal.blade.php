<flux:modal name="new-assignment" class="md:w-[32rem] bg-white dark:bg-gray-800">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">
                Add Assignment
            </flux:heading>

            <flux:text class="mt-2">
                Create a new assignment for this subject.
            </flux:text>
        </div>

        <form method="POST" action="{{ route('assignments.add') }}" class="space-y-4">
            @csrf
            <input type="hidden" value="{{ $subject['id'] }}" name="subject_id">

            <flux:field>
                <flux:label>Assignment Title</flux:label>
                <flux:input name="title" type="text" placeholder="e.g. Chapter Review" />
            </flux:field>

            <flux:field>
                <flux:label>Due Date</flux:label>
                <flux:input name="deadline" type="date" />
            </flux:field>

            <flux:field>
                <flux:label>Additional Remarks</flux:label>
                <flux:textarea name="details" rows="4" class="resize-none" />
            </flux:field>

            <div class="flex justify-end gap-3 pt-2">
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Save Assignment
                </flux:button>

                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        Cancel
                    </flux:button>
                </flux:modal.close>
            </div>
        </form>
    </div>
</flux:modal>
