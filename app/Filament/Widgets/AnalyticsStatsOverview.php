<?php

namespace App\Filament\Widgets;

use App\Models\AnalyticsEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AnalyticsStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        // Default query (all time)
        $pageViewsQuery = AnalyticsEvent::where('event_type', 'page_view');
        $pricingViewsQuery = AnalyticsEvent::where('event_type', 'section_view')->where('event_data->section', 'pricing');
        $articleClicksQuery = AnalyticsEvent::where('event_type', 'article_click');

        // Apply Date Filters from Dashboard if available
        // Note: This requires the Dashboard to use a filter form, which is a more advanced setup.
        // For a simple widget-level filter, we rely on the Chart widget's state or a global filter if configured.
        
        // Calculating growth (example: vs last week)
        $lastWeekStart = now()->subWeek();
        
        $pageViews = $pageViewsQuery->count();
        $pageViewsLastWeek = AnalyticsEvent::where('event_type', 'page_view')->where('created_at', '>=', $lastWeekStart)->count();
        
        $pricingViews = $pricingViewsQuery->count();
        $articleClicks = $articleClicksQuery->count();

        return [
            Stat::make('Total Page Views', $pageViews)
                ->description('Total visits all time')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success')
                ->chart([
                    AnalyticsEvent::where('event_type', 'page_view')->where('created_at', '>=', now()->subDays(7))->count(),
                    $pageViews
                ]),
            Stat::make('Pricing Section Views', $pricingViews)
                ->description('Total interested visitors')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
            Stat::make('Article Clicks', $articleClicks)
                ->description('Total blog engagement')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }
}
