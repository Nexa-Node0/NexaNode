@php
$currentPage = \Filament\Facades\Filament::getCurrentPage();
$breadcrumbs = $currentPage?->getBreadcrumbs() ?? [];

@endphp

<x-filament::breadcrumbs :breadcrumbs="$breadcrumbs" />