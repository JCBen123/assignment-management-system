<script>
    document.querySelectorAll('[data-id]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('assignment_id').value = button.dataset.id;
            document.getElementById('assignment_title').value = button.dataset.title;
            document.getElementById('assignment_deadline').value = button.dataset.deadline;
            document.getElementById('assignment_remarks').value = button.dataset.remarks ?? '';
        });
    });
</script>

<flux:modal name="edit-assignment" class="md:w-[32rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Edit Assignment</flux:heading>
            <flux:text class="mt-2">
                Update the assignment details
            </flux:text>
        </div>

        <form method="POST" action="{{ route('assignments.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="assignment_id" name="id">

            <flux:field>
                <flux:label>Assignment Title</flux:label>
                <flux:input id="assignment_title" name="title" type="text" placeholder="e.g. Chapter Review" required />
            </flux:field>

            <flux:field>
                <flux:label>Due Date</flux:label>
                <flux:input id="assignment_deadline" name="deadline" type="date" required />
            </flux:field>

            <flux:field>
                <flux:label>Additional Remarks</flux:label>
                <flux:textarea id="assignment_remarks" name="remarks" rows="4" class="resize-none" />
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Save
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
