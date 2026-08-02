<flux:modal name="new-subject" class="md:w-[32rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Add New Subject</flux:heading>
            <flux:text class="mt-2">
                Add a new subject and start organizing assignments.
            </flux:text>
        </div>

        <form method="POST" action="{{ route('subjects.add') }}" class="space-y-4">
            @csrf

            <flux:field>
                <flux:label>Subject Name</flux:label>
                <flux:input name="name" type="text" placeholder="e.g. Literature" required />
            </flux:field>

            <flux:field>
                <flux:label>Subject Code</flux:label>
                <flux:input name="code" type="text" placeholder="e.g. LIT301" required />
            </flux:field>

            <flux:field>
                <flux:label>Additional Remarks</flux:label>
                <flux:textarea name="remarks" rows="4" placeholder="e.g. Advanced Literature" class="resize-none" />
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Add
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
