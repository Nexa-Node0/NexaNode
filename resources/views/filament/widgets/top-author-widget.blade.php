<x-filament-widgets::widget>
    <x-filament::section>

        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-filament::icon
                    icon="heroicon-m-user-group"
                    class="h-5 w-5 text-primary-500"
                />
                Top Authors
            </div>
        </x-slot>

        <x-slot name="description">
            Users ranked by number of published posts
        </x-slot>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            @forelse ($this->getTopAuthors() as $index => $user)
                <div
                    @class([
                        'relative flex items-center gap-4 rounded-xl p-4 border',
                        'bg-yellow-950/30 border-yellow-500/40' => $index === 0,
                        'bg-gray-800/50 border-gray-500/40'     => $index === 1,
                        'bg-orange-950/30 border-orange-500/40' => $index === 2,
                    ])
                >
                    {{-- Rank Badge --}}
                    <span @class([
                        'absolute top-2 right-3 text-xs font-bold',
                        'text-yellow-400' => $index === 0,
                        'text-gray-400'   => $index === 1,
                        'text-orange-400' => $index === 2,
                    ])>
                        @switch($index)
                            @case(0) 🥇 #1 @break
                            @case(1) 🥈 #2 @break
                            @case(2) 🥉 #3 @break
                        @endswitch
                    </span>

                    {{-- Avatar --}}
                    <div @class([
                        'flex h-12 w-12 shrink-0 items-center justify-center rounded-full text-lg font-bold text-white',
                        'bg-yellow-500' => $index === 0,
                        'bg-gray-500'   => $index === 1,
                        'bg-orange-500' => $index === 2,
                    ])>
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>

                    {{-- Info --}}
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-white">
                            {{ $user->name }}
                        </p>
                        <p class="text-sm text-gray-400">
                            {{ $user->posts_count }}
                            {{ Str::plural('post', $user->posts_count) }} published
                        </p>
                        {{-- Role Badge --}}
                        <span class="inline-flex items-center rounded-full bg-primary-500/20 px-2 py-0.5 text-xs text-primary-400">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    </div>

                </div>
            @empty
                <p class="col-span-3 text-center text-sm text-gray-500">
                    No authors found.
                </p>
            @endforelse

        </div>

    </x-filament::section>
</x-filament-widgets::widget>