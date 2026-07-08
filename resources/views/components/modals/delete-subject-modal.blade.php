<script>
    document.querySelectorAll('[data-id]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('id').value = button.dataset.id;
        });
    });
</script>

<flux:modal name="delete-subject" class="md:w-[24rem]">
    <div class="space-y-5">
        <div>
            <flux:heading size="lg">Delete subject?</flux:heading>
            <flux:text class="mt-2">
                This will remove the subject and its related assignments. This action cannot be undone.
            </flux:text>
        </div>

        <form method="POST" action="{{ route('subjects.delete') }}" class="flex justify-end gap-3">
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
