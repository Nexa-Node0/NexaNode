<x-filament::section
    :aside="true"
    :collapsible="true"
    :icon="'heroicon-o-trash'"
    :heading="__('Delete Account')"
    :description="__('Permanently delete your account and all of its data. This action cannot be undone.')">
    <div class="space-y-4">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Once your account is deleted, all of your data will be permanently removed.
            Before deleting, please download any information you wish to retain.
        </p>

        {{ ($this->form) }}
    </div>

    <x-filament-actions::modals />
</x-filament::section>