<x-filament-panels::page>

    {{-- FILTER BAR + TAB TOGGLE --}}
    <div class="flex flex-wrap items-center justify-between gap-3">

        {{-- Left: Search + Category Filter --}}
        <div class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <x-filament::input.wrapper leading-icon="heroicon-o-magnifying-glass" class="w-72" :valid="true">
                <x-filament::input type="text" wire:model.live.debounce.300ms="searchedWord"
                    placeholder="Search by product or brand…" />
            </x-filament::input.wrapper>

            {{-- Category Select --}}
            <x-filament::input.wrapper class="w-56">
                <x-filament::input.select wire:model.live="selectedCategory">
                    <option value="">All Categories</option>
                    @foreach ($this->getCategoryOptions() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>

            {{-- Clear filters --}}
            @if ($selectedCategory || filled($searchedWord))
                <x-filament::button color="gray" size="sm"
                    wire:click="$set('selectedCategory', null); $set('searchedWord', '')" icon="heroicon-o-x-mark">
                    Clear
                </x-filament::button>
            @endif

        </div>

        {{-- Right: Grid / Table Tab Toggle --}}
        <div
            class="flex items-center rounded-lg border border-gray-200 bg-white p-1 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <button wire:click="setTab('grid')" @class([
                'flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium transition-all duration-150',
                'bg-primary-600 text-white shadow-sm' => $activeTab === 'grid',
                'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' =>
                    $activeTab !== 'grid',
            ])>
                <x-filament::icon icon="heroicon-o-squares-2x2" class="h-4 w-4" />
                <span>Grid</span>
            </button>
            <button wire:click="setTab('table')" @class([
                'flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium transition-all duration-150',
                'bg-primary-600 text-white shadow-sm' => $activeTab === 'table',
                'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' =>
                    $activeTab !== 'table',
            ])>
                <x-filament::icon icon="heroicon-o-list-bullet" class="h-4 w-4" />
                <span>Table</span>
            </button>
        </div>

    </div>

    {{-- EMPTY STATE --}}
    @if ($possessions->isEmpty())
        <x-filament::section>
            <div class="flex flex-col items-center justify-center py-12 text-center text-gray-500">
                <x-filament::icon icon="heroicon-o-briefcase" class="h-12 w-12 mb-4 text-gray-400" />
                @if (filled($searchedWord) || $selectedCategory)
                    <p class="text-lg font-medium">No results found</p>
                    <p class="text-sm">Try adjusting your search or filter.</p>
                @else
                    <p class="text-lg font-medium">No possessions yet</p>
                    <p class="text-sm">Items assigned to you will appear here.</p>
                @endif
            </div>
        </x-filament::section>
    @elseif ($activeTab === 'grid')
        {{-- GRID VIEW --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($possessions as $item)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5">
                                @if ($item->product->brand?->logo)
                                    <img src="{{ Storage::url($item->product->brand?->logo) }}" alt="Logo"
                                        class="h-6 w-6 shrink-0">
                                @else
                                    <x-filament::icon icon="heroicon-m-ticket" class="h-3.5 w-3.5 shrink-0" />
                                @endif
                                <span class="truncate text-sm font-semibold">{{ $item->product->name }}</span>
                            </div>
                            <x-filament::badge :color="$item->status->color()">
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
    @else
        {{-- TABLE VIEW --}}
        <x-filament::section>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3 pr-4 font-semibold text-gray-700 dark:text-gray-300">Image</th>
                            <th class="py-3 pr-4 font-semibold text-gray-700 dark:text-gray-300">Product</th>
                            <th class="py-3 pr-4 font-semibold text-gray-700 dark:text-gray-300">Brand</th>
                            <th class="py-3 pr-4 font-semibold text-gray-700 dark:text-gray-300">Category</th>
                            <th class="py-3 pr-4 font-semibold text-gray-700 dark:text-gray-300">Status</th>
                            <th class="py-3 font-semibold text-gray-700 dark:text-gray-300">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($possessions as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-100">

                                <td class="py-3 pr-4">
                                    @if ($item->product->image)
                                        <img src="{{ $item->product->display_image }}" alt="{{ $item->product->name }}"
                                            class="h-10 w-10 rounded-md object-cover" />
                                    @else
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800">
                                            <x-filament::icon icon="heroicon-o-photo" class="h-5 w-5 text-gray-400" />
                                        </div>
                                    @endif
                                </td>

                                <td class="py-3 pr-4 font-medium text-gray-900 dark:text-white">
                                    {{ $item->product->name }}
                                </td>

                                <td class="py-3 pr-4 text-gray-500 dark:text-gray-400">
                                    {{ $item->product->brand?->name ?? '—' }}
                                </td>

                                <td class="py-3 pr-4 text-gray-500 dark:text-gray-400">
                                    {{ $item->product->category?->name ?? '—' }}
                                </td>

                                <td class="py-3 pr-4">
                                    <x-filament::badge :color="$item->status->color()">
                                        {{ $item->status->label() }}
                                    </x-filament::badge>
                                </td>

                                <td class="py-3 max-w-xs text-gray-500 dark:text-gray-400">
                                    <span class="line-clamp-2">{{ $item->notes ?? 'No notes' }}</span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    @endif

</x-filament-panels::page>
