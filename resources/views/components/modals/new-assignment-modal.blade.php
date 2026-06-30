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

        <form class="space-y-4">
            <flux:field>
                <flux:label>Assignment Title</flux:label>
                <flux:input
                    id="assignment-title"
                    type="text"
                    placeholder="e.g. Chapter Review"
                />
            </flux:field>

            <flux:field>
                <flux:label>Due Date</flux:label>
                <flux:input
                    id="deadline"
                    type="date"
                />
            </flux:field>

            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select id="status">
                    <flux:select.option>
                        Pending
                    </flux:select.option>
                    <flux:select.option>
                        Completed
                    </flux:select.option>
                    <flux:select.option>
                        Overdue
                    </flux:select.option>
                </flux:select>
            </flux:field>

            <div class="flex justify-end gap-3 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost">
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">
                    Save Assignment
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
