{{-- resources/views/auth/left-panel.blade.php --}}
<div class="flex flex-col justify-between h-full w-full px-10 py-16 min-h-screen">

    {{-- Top: Branding --}}
    <div>
        <div class="mb-2">
            <img src="{{ Storage::url(setting('general.favicon')) }}" alt="" width="100px">
            <span class="text-white font-bold text-3xl tracking-tight drop-shadow-sm">
                {{ setting('general.brand_name', config('app.name', 'Laravel')) }}
            </span>
        </div>
        <p class="text-blue-100 text-sm font-medium tracking-wide">
            Your all-in-one solution for rapid application development
        </p>
    </div>

    {{-- Middle: Feature Cards --}}
    <div class="flex flex-col gap-4 my-10">

        {{-- Feature 1 --}}
        <div class="flex items-start gap-4 bg-blue-300/40 border border-blue-300/60 rounded-xl px-5 py-4 backdrop-blur-sm">
            <div class="mt-0.5 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <p class="text-white font-semibold text-sm leading-snug">Lightning Fast</p>
                <p class="text-blue-100 text-xs mt-0.5 leading-relaxed">Build powerful admin panels in minutes</p>
            </div>
        </div>

        {{-- Feature 2 --}}
        <div class="flex items-start gap-4 bg-blue-300/40 border border-blue-300/60 rounded-xl px-5 py-4 backdrop-blur-sm">
            <div class="mt-0.5 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </div>
            <div>
                <p class="text-white font-semibold text-sm leading-snug">Flexible &amp; Modular</p>
                <p class="text-blue-100 text-xs mt-0.5 leading-relaxed">Customize every aspect with ease</p>
            </div>
        </div>

        {{-- Feature 3 --}}
        <div class="flex items-start gap-4 bg-blue-300/40 border border-blue-300/60 rounded-xl px-5 py-4 backdrop-blur-sm">
            <div class="mt-0.5 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <div>
                <p class="text-white font-semibold text-sm leading-snug">Feature Rich</p>
                <p class="text-blue-100 text-xs mt-0.5 leading-relaxed">Advanced features built right in</p>
            </div>
        </div>

        {{-- Feature 4 --}}
        <div class="flex items-start gap-4 bg-blue-300/40 border border-blue-300/60 rounded-xl px-5 py-4 backdrop-blur-sm">
            <div class="mt-0.5 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <p class="text-white font-semibold text-sm leading-snug">Secure &amp; Reliable</p>
                <p class="text-blue-100 text-xs mt-0.5 leading-relaxed">Built on Laravel's solid foundation</p>
            </div>
        </div>

    </div>

    {{-- Bottom: Footer Text --}}
    <div>
        <p class="text-blue-100 text-xs text-center">
            Please log in to access your admin panel!
        </p>
    </div>

</div>