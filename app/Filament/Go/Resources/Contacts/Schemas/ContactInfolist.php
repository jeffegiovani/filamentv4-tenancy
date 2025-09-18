<?php

namespace App\Filament\Go\Resources\Contacts\Schemas;

use App\Models\Contact;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tenant_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('birth_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('emails')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('phones')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('identification_documents')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('addresses')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('urls')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('info')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_company')
                    ->boolean(),
                TextEntry::make('utm_source_id')
                    ->placeholder('-'),
                TextEntry::make('utm_source_uri_or_detail')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Contact $record): bool => $record->trashed()),
                TextEntry::make('migration_metadata')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
