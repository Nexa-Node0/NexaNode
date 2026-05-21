<x-filament-panels::page>

    {{-- FILTER BAR --}}
    <div class="flex items-center gap-3">
        <x-filament::input.wrapper class="w-64">
            <x-filament::input.select wire:model.live="selectedCategory">
                <option value="">All Categories</option>
                @foreach ($this->getCategoryOptions() as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>

        @if ($selectedCategory)
            <x-filament::button color="gray" size="sm" wire:click="$set('selectedCategory', null)"
                icon="heroicon-o-x-mark">
                Clear
            </x-filament::button>
        @endif
    </div>

    {{-- GRID --}}
    @if ($possessions->isEmpty())
        <x-filament::section>
            <div class="flex flex-col items-center justify-center py-12 text-center text-gray-500">
                <x-filament::icon icon="heroicon-o-briefcase" class="h-12 w-12 mb-4 text-gray-400" />
                <p class="text-lg font-medium">No possessions yet</p>
                <p class="text-sm">Items assigned to you will appear here.</p>
            </div>
        </x-filament::section>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($possessions as $item)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between gap-2">
                            <span class="truncate text-sm font-semibold">{{ $item->product->name }}</span>
                            <x-filament::badge :color="match ($item->status) {
                                \App\Enums\ProductStatusEnum::Active => 'success',
                                \App\Enums\ProductStatusEnum::Returned => 'gray',
                                \App\Enums\ProductStatusEnum::Lost => 'danger',
                                \App\Enums\ProductStatusEnum::Destroyed => 'warning',
                            }">
                                {{ $item->status->label() }}
                            </x-filament::badge>
                        </div>
                    </x-slot>

                    <div class="my-2 overflow-hidden rounded-lg">
                        @if ($item->product->image)
                            <img src="{{ $item->product->display_image }}" alt="{{ $item->product->name }}"
                                class="h-32 w-full object-cover" />
                        @else
                            <div
                                class="flex h-32 w-full items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                                <x-filament::icon icon="heroicon-o-photo" class="h-8 w-8 text-gray-400" />
                            </div>
                        @endif
                    </div>

                    <div class="space-y-1 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-1.5">
                            <x-filament::icon icon="heroicon-o-tag" class="h-3.5 w-3.5 shrink-0" />
                            <span>{{ $item->product->category?->name ?? '—' }}</span>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <x-filament::icon icon="heroicon-o-chat-bubble-left-ellipsis"
                                class="h-3.5 w-3.5 mt-0.5 shrink-0" />
                            <span class="line-clamp-2">{{ $item->notes ?? 'No notes' }}</span>
                        </div>
                    </div>
                </x-filament::section>
            @endforeach
        </div>
    @endif

</x-filament-panels::page>
