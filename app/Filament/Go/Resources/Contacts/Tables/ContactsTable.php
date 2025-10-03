<?php

namespace App\Filament\Go\Resources\Contacts\Tables;

use App\Filament\Go\Resources\Contacts\Tables\Columns\AllTableColumns;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->searchPlaceholder('nome, nasc, email, fone')
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'name',
                        'birth_date',
                        'emails',
                        'phones',
                        'is_company',
                        'utm_source_id',
                        'created_at',
                        'updated_at',
                    ])
                    ->with([
                        'utmSource',
                    ]);
            })
            ->defaultSort('name', 'ASC')
            ->columns([
                //...AllTableColumns::make(),
                TextColumn::make('utm_source_id')
                    ->action(fn($record) => dd('Test'))
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
