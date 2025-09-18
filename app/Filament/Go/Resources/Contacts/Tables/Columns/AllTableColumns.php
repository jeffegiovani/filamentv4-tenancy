<?php

namespace App\Filament\Go\Resources\Contacts\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Tables\Columns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class AllTableColumns
{
    public static function make(): array
    {
        return [
            TextColumn::make('properties_count')
                ->state(fn() => 1)
                ->alignCenter()
                ->label(new HtmlString(Blade::render("@svg('phosphor-building-office', ['class' => 'size-6'])"))),

            TextColumn::make('name')
                ->searchable()
                ->limit(40)
                ->label('Nome'),

            TextColumn::make('birth_date')
                ->date()
                ->searchable()
                ->description(fn($state) => new HtmlString('<small class="block leading-none">' . str($state?->diffForHumans())->replace('há ', '') . '</small>'))
                ->label('Nascimento'),

            TextColumn::make('first_email_account')
                ->searchable()
                ->copyable()
                ->icon(Phosphor::Copy)
                ->iconPosition('after')
                ->searchable(query: function (Builder $query, string $search) {
                    $query->whereRaw(
                        "JSON_UNQUOTE(JSON_EXTRACT(emails, '$[*].value')) LIKE ?",
                        ["%{$search}%"]
                    );
                })
                ->sortable(query: function (Builder $query, string $direction) {
                    $query->orderByRaw(
                        "JSON_UNQUOTE(JSON_EXTRACT(emails, '$[0].value')) {$direction}"
                    );
                })
                ->description(
                    fn($record) => (count($record->emails ?? []) > 1)
                        ? new HtmlString('<small class="block leading-none">e mais ' . (count($record->emails) - 1) . ' email(s)</small>')
                        : null
                )
                ->label('Email Primário'),

            IconColumn::make('is_company')
                ->alignCenter()
                ->boolean()
                ->label('Empresa?'),

            TextColumn::make('utmSource.title')
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Origem'),

            TextColumn::make('created_at')
                ->dateTime()
                ->label('Criação'),

            TextColumn::make('updated_at')
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Atualização'),
        ];
    }
}
