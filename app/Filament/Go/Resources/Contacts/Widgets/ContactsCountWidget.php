<?php

namespace App\Filament\Go\Resources\Contacts\Widgets;

use App\Models\Contact;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class ContactsCountWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static bool $isLazy = true;

    public function getColumns(): int
    {
        return 1;
    }

    protected int|string|array $columnSpan = [
        'default' => 1,
        // 'md' => 1,
    ];

    protected function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        return [
            Stat::make(
                label: 'Pessoas & Empresas',
                value: Contact::query()
                    ->where('tenant_id', Filament::getTenant()->id)
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            ),
        ];
    }
}
