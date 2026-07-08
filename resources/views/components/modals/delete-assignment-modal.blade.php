<script>
    document.querySelectorAll('[data-id]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('id').value = button.dataset.id;
        });
    });
</script>

<flux:modal name="delete-assignment" class="md:w-[24rem]">
    <div class="space-y-5">
        <div>
            <flux:heading size="lg">Delete assignment?</flux:heading>
            <flux:text class="mt-2">
                This action cannot be undone. The assignment will be removed permanently.
            </flux:text>
        </div>

        <form method="POST" action="{{ route('assignments.delete') }}" class="flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <input type="hidden" id="id" name="id">

            <flux:modal.close>
                <flux:button variant="ghost" class="cursor-pointer">
                    Cancel
                </flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" class="cursor-pointer">
                Delete
            </flux:button>
        </form>
    </div>
</flux:modal>
