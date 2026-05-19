<x-filament::section
    :aside="true"
    :icon="'heroicon-o-finger-print'"
    :collapsible="true"
    :heading="__('filament-breezy::default.profile.passkeys.heading')"
    :description="__('filament-breezy::default.profile.passkeys.description')">
    <div>
        {{ $this->table }}
    </div>
</x-filament::section>

@include('filament-breezy::livewire.passkeys.create-script')