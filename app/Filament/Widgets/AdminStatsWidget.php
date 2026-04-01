<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AdminStatsWidget extends StatsOverviewWidget
{
    use HasWidgetShield;
    protected function getStats(): array
    {
        return [
           Stat::make('Total Users', User::count()),
        ];
    }
}
