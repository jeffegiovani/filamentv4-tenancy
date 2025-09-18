<?php

namespace App\Filament\Go\Resources\Contacts\Schemas\Infolists;

use Filament\Infolists\Components\TextEntry;

class MigrationMetadataTextEntry
{
    public static function make()
    {
        return TextEntry::make('migration_metadata')
            ->default(null)
            ->hiddenOn('create')
            ->columnSpanFull();
    }
}
