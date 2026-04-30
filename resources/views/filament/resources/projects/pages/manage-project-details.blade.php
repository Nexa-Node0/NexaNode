<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Project Details</x-slot>

        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-4 flex justify-end">
                <x-filament::button type="submit">
                    Save Details
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
