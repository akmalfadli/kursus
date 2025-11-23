<?php

namespace App\Filament\Widgets;

use App\Models\AnalyticsEvent;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class AnalyticsChart extends ChartWidget
{
    protected static ?string $heading = 'Visitor Analytics';
    
    protected int | string | array $columnSpan = 'full';
    
    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last Week',
            'month' => 'Last Month',
            'year' => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        switch ($activeFilter) {
            case 'today':
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                $per = 'perHour';
                break;
            case 'month':
                $start = now()->subMonth()->startOfDay();
                $end = now()->endOfDay();
                $per = 'perDay';
                break;
            case 'year':
                $start = now()->startOfYear();
                $end = now()->endOfDay();
                $per = 'perMonth';
                break;
            case 'week':
            default:
                $start = now()->subWeek()->startOfDay();
                $end = now()->endOfDay();
                $per = 'perDay';
                break;
        }

        $pageViews = Trend::query(AnalyticsEvent::where('event_type', 'page_view'))
            ->between(start: $start, end: $end)
            ->$per()
            ->count();

        $pricingViews = Trend::query(AnalyticsEvent::where('event_type', 'section_view')->where('event_data->section', 'pricing'))
            ->between(start: $start, end: $end)
            ->$per()
            ->count();

        $articleClicks = Trend::query(AnalyticsEvent::where('event_type', 'article_click'))
            ->between(start: $start, end: $end)
            ->$per()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Page Views',
                    'data' => $pageViews->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // blue
                ],
                [
                    'label' => 'Pricing Views',
                    'data' => $pricingViews->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#eab308', // yellow
                ],
                [
                    'label' => 'Article Clicks',
                    'data' => $articleClicks->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ef4444', // red
                ],
            ],
            'labels' => $pageViews->map(fn (TrendValue $value) => $activeFilter === 'today' ? Carbon::parse($value->date)->format('H:i') : Carbon::parse($value->date)->format('M d')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
