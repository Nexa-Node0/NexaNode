<div class="px-4">
    <div class="leading-tight">
        <p class="text-sm font-semibold text-dark dark:text-white darl">
            {{ auth()->user()->name }}
        </p>
        <hr class="m-0 p-0 border-gray-400 dark::border-gray-100">
        <p class="text-xs text-gray-400 dark:text-gray-100">
            {{ auth()->user()->position->name }}
        </p>
    </div>
</div>