<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\StockMovement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class InventoryStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::whereColumn('quantity', '<=', 'low_stock_threshold')->count();
        $totalValue = Product::sum(
            DB::raw('quantity * price')
        ) ?? 0;
        $thisMonthMovements = StockMovement::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        return [
            Stat::make('Total Products', $totalProducts)
                ->description('Active inventory items')
                ->descriptionIcon('heroicon-m-square-3-stack-3d')
                ->color('info'),

            Stat::make('Low Stock', $lowStockCount)
                ->description($lowStockCount > 0 ? 'Need reorder' : 'All normal')
                ->descriptionIcon($lowStockCount > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),

            Stat::make('Inventory Value', '$' . Number::format($totalValue, precision: 2))
                ->description('Total stock value')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),

            Stat::make('Movements (This Month)', $thisMonthMovements)
                ->description('Stock transactions')
                ->descriptionIcon('heroicon-m-arrow-right-left')
                ->color('primary'),
        ];
    }
}
