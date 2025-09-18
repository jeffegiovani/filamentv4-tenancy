<?php

namespace App\Filament\Go\Resources\Contacts;

use App\Filament\Go\Resources\Contacts\Pages\CreateContact;
use App\Filament\Go\Resources\Contacts\Pages\EditContact;
use App\Filament\Go\Resources\Contacts\Pages\ListContacts;
use App\Filament\Go\Resources\Contacts\Pages\ViewContact;
use App\Filament\Go\Resources\Contacts\Schemas\ContactForm;
use App\Filament\Go\Resources\Contacts\Schemas\ContactInfolist;
use App\Filament\Go\Resources\Contacts\Tables\ContactsTable;
use App\Models\Contact;
use BackedEnum;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $slug = 'contatos';

    /**
     * NAVIGATION THINGS
     */
    protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = null;
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationBadgeTooltip = null;
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?string $navigationParentItem = null;
    protected static string | \BackedEnum | null $navigationIcon = Phosphor::Users;
    protected static string | \BackedEnum | null $activeNavigationIcon = Phosphor::UsersFill;
    protected static ?string $navigationLabel = 'Pessoas e Empresas';
    protected static ?int $navigationSort = null;

    /**
     * LABEL THINGS
     */
    protected static ?string $modelLabel = 'Contato (Pessoa/Empresa)';
    protected static ?string $pluralModelLabel = 'Pessoas e Empresas';
    protected static ?string $recordTitleAttribute = 'name';
    protected static bool $hasTitleCaseModelLabel = false;

    /**
     * GLOBAL SEARCH THINGS
     */
    protected static int $globalSearchResultsLimit = 8;
    protected static ?bool $isGlobalSearchForcedCaseInsensitive = null;
    protected static ?bool $shouldSplitGlobalSearchTerms = null;
    protected static bool $isGloballySearchable = true;

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'identification_documents', 'phones', 'emails'];
    }

    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('Ver')
                ->url(static::getUrl('view', ['record' => $record])),

            Action::make('Editar')
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return ContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'view' => ViewContact::route('/{record}'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
