<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;
use App\Models\User;

class TopAuthorWidget extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        $topAuthors = $this->getTopAuthors();
        
        $stats = [];
        foreach ($topAuthors as $author) {
            $stats[] = Stat::make($author->name, $author->posts_count)
                ->description('Posts by this author')
                ->icon('heroicon-o-user');
        }
        
        return $stats;
    }

    public function getTopAuthors(): \Illuminate\Support\Collection {
        return User::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(3)
            ->get();
    }
}
