<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\PostCategory;

class PostCategoriesWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $isVisibleCount = $this->getActiveCategory();
        $isNotVisibleCount = $this->getInactiveCategory();
        $mostUsedCategory = $this->getMostUsedCategory();

        return [
            Stat::make('Most used category', number_format($mostUsedCategory->posts_count ?? 0))
                ->description($mostUsedCategory->name ?? 'No category has been used')
                ->icon('heroicon-o-tag')
                ->color('success'),

            Stat::make('Active', number_format($isVisibleCount))
                ->description('Available for post assignment')
                ->icon('heroicon-o-check-circle')
                ->color('primary'),

            Stat::make('Inactive', number_format($isNotVisibleCount))
                ->description('Hidden from selection')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
        ];
    }

    private function getMostUsedCategory(): ?PostCategory{
        return PostCategory::withCount('posts')
            ->orderByDesc('posts_count')
            ->first();
    }

    private function getActiveCategory(): int{
        return PostCategory::where('is_visible', true)->count();
    }

    private function getInactiveCategory(): int{
        return PostCategory::where('is_visible', false)->count();
    }

}
