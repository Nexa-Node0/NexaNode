<x-filament::section :aside="true" :collapsible="true" icon="'heroicon-s-lock-closed'" :heading="__('filament-breezy::default.profile.password.heading')" :description="__('filament-breezy::default.profile.password.subheading')">
    <form wire:submit.prevent="submit" class="space-y-6">

        {{ $this->form }}

        <div class="text-right">
            <x-filament::button type="submit" form="submit" class="align-right">
                {{ __('filament-breezy::default.profile.password.submit.label') }}
            </x-filament::button>
        </div>
    </form>
</x-filament::section>