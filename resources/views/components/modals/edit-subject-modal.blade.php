<script>
    document.querySelectorAll('[data-id]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('subject_id').value = button.dataset.id;
            document.getElementById('subject_name').value = button.dataset.name;
            document.getElementById('subject_code').value = button.dataset.code;
            document.getElementById('subject_remarks').value = button.dataset.remarks ?? '';
        });
    });
</script>

<flux:modal name="edit-subject" class="md:w-[32rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Edit Subject</flux:heading>
            <flux:text class="mt-2">
                Update the subject details and save your changes.
            </flux:text>
        </div>

        <form method="POST" action="{{ route('subjects.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="subject_id" name="id">

            <flux:field>
                <flux:label>Subject Name</flux:label>
                <flux:input id="subject_name" name="name" type="text" placeholder="e.g. Literature" required />
            </flux:field>

            <flux:field>
                <flux:label>Subject Code</flux:label>
                <flux:input id="subject_code" name="code" type="text" placeholder="e.g. LIT301" required />
            </flux:field>

            <flux:field>
                <flux:label>Additional Remarks</flux:label>
                <flux:textarea id="subject_remarks" name="remarks" rows="4" placeholder="e.g. Advanced Literature" class="resize-none" />
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
