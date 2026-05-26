<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use Carbon\Carbon;
use App\Enums\PostStatus;

class BlogWidget extends StatsOverviewWidget
{

    protected function getStats(): array
    {
        $totalPost = Post::count();
        $postGrowth = $this->getPostGrowth();
        $postTrend = $this->getPostPerDay();


        $totalPublishedPost = Post::where('status', PostStatus::Published->value)->count();
        $publishedGrowth = $this->getPublishedPostGrowth();

        $draftPosts = Post::where('status',  PostStatus::Draft->value)->count();
        $unpublishedPosts = Post::where('status', PostStatus::Archived->value)->count();

        return [
            Stat::make('Total', number_format($totalPost))
                ->description($postGrowth . '% from last month')
                ->descriptionIcon($postGrowth > 0
                    ? 'heroicon-m-arrow-trending-up'
                    : 'heroicon-m-arrow-trending-down')
                ->icon('heroicon-o-document-text')
                ->chart($postTrend)
                ->color($postGrowth > 0 ? 'success' : 'danger')
                ->url(route('filament.admin.resources.blog.posts.index')),

            Stat::make('Published', number_format($totalPublishedPost))
                ->description($publishedGrowth . '% from last month')
                ->descriptionIcon($publishedGrowth > 0
                    ? 'heroicon-m-arrow-trending-up'
                    : 'heroicon-m-arrow-trending-down')
                ->icon('heroicon-o-rocket-launch')
                ->url(route('filament.admin.resources.blog.posts.index', ['filters[status][values][0]' =>  PostStatus::Published->value])),


            Stat::make('Draft', number_format($draftPosts))
                ->description('Posts awaiting publication')
                ->icon('heroicon-o-pencil-square')
                ->color('danger')
                ->url(route('filament.admin.resources.blog.posts.index', ['filters[status][values][0]' =>  PostStatus::Draft->value])),

            Stat::make('Archived', number_format($unpublishedPosts))
                ->description('Total posts not yet published')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->url(route('filament.admin.resources.blog.posts.index', ['filters[status][values][0]' => PostStatus::Archived->value])),


        ];
    }


    private function getPublishedPostGrowth()
    {

        $now = Carbon::now();

        $startCurrentMonth =  $now->copy()->startOfMonth();

        $startOfLastMonth = $now->copy()->startOfMonth();
        $endOfLastMonth =  $now->copy()->subMonth()->endOfMonth();

        $thisMonthTotal = Post::query()
            ->whereBetween('created_at', [$startCurrentMonth, $now])
            ->where('status', 'Published')
            ->count();

        $lastMonthTotal = Post::query()
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->where('status', 'Published')
            ->count();

        if ($lastMonthTotal > 0) {
            return round((($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100, 1);
        }

        return $thisMonthTotal > 0 ? 100 : 0;
    }


    /**
     * Get post counts for each day of the current month.
     *
     * Returns an array with values for each day in the month,
     * filling gaps with 0, so the chart renders continuously.
     */
    private function getPostPerDay(): array
    {

        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $postPerDay = Post::query()
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        // Fill missing date to 0
        $postTrend = collect();

        for ($date = $startMonth->copy(); $date <= $endMonth; $date->addDay()) {
            $postTrend->push($postPerDay[$date->toString()] ?? 0);
        }

        return $postTrend->toArray();
    }

    /**
     * Calculate the percentage growth in posts compared to last month.
     *
     * If last month has 0 posts, returns 100 when current month > 0, otherwise 0.
     */
    private function getPostGrowth(): float
    {

        $startOfTheCurrentMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();


        $currentMonthTotal = Post::whereBetween('created_at', [
            $startOfTheCurrentMonth,
            now()
        ])->count();

        $lastMonthTotal = Post::where('created_at', [
            $startOfLastMonth,
            $endOfLastMonth
        ])->count();

        // avoid division by zero
        if ($lastMonthTotal > 0) {
            return round((($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100, 1);
        }

        return $currentMonthTotal > 0 ? 100 : 0;
    }
}
