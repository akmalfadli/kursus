<?php
// app/Filament/Pages/Reports.php

namespace App\Filament\Pages;

use App\Models\Transaction;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Illuminate\Support\Carbon;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.reports';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $title = 'Laporan Penjualan';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'date_from' => now()->startOfMonth(),
            'date_to' => now(),
            'status' => 'all',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date_from')
                    ->label('Dari Tanggal')
                    ->default(now()->startOfMonth()),
                DatePicker::make('date_to')
                    ->label('Sampai Tanggal')
                    ->default(now()),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'all' => 'Semua',
                        'paid' => 'Lunas',
                        'pending' => 'Pending',
                        'failed' => 'Gagal',
                    ])
                    ->default('all'),
            ])
            ->columns(3)
            ->statePath('data');
    }

    public function getReportData(): array
    {
        $query = Transaction::query();

        if ($this->data['date_from']) {
            $query->whereDate('created_at', '>=', $this->data['date_from']);
        }

        if ($this->data['date_to']) {
            $query->whereDate('created_at', '<=', $this->data['date_to']);
        }

        if ($this->data['status'] !== 'all') {
            $query->where('payment_status', $this->data['status']);
        }

        $transactions = $query->get();

        return [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->where('payment_status', 'paid')->sum('amount'),
            'pending_count' => $transactions->where('payment_status', 'pending')->count(),
            'failed_count' => $transactions->where('payment_status', 'failed')->count(),
            'success_rate' => $transactions->count() > 0
                ? round(($transactions->where('payment_status', 'paid')->count() / $transactions->count()) * 100, 2)
                : 0,
        ];
    }
}
