<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Project Summary</x-slot>

        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-4 flex justify-end gap-2">
                <x-filament::button type="button" color="gray" tag="a" :href="$this->getResource()::getUrl('view', ['record' => $this->record])">
                    Back
                </x-filament::button>
                <x-filament::button type="submit">
                    Save Details
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
