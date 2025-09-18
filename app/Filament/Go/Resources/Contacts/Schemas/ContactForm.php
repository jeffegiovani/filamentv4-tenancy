<?php

namespace App\Filament\Go\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Go\Resources\Contacts\Schemas\Forms\EmailsRepeater;
use App\Filament\Go\Resources\Contacts\Schemas\Forms\DocumentsRepeater;
use App\Filament\Go\Resources\Contacts\Schemas\Forms\UrlsRepeater;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use App\Filament\Go\Resources\Contacts\Schemas\Infolists\MigrationMetadataTextEntry;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'lg' => 3,
                ])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->columnSpan([
                                'default' => 'full',
                                'lg' => 2,
                            ])
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(120)
                                    ->validationAttribute('Nome do Contato')
                                    ->label('Nome do Contato'),

                                DatePicker::make('birth_date')
                                    ->nullable()
                                    ->label('Data de Nascimento'),

                                EmailsRepeater::make(),

                                DocumentsRepeater::make(),

                                UrlsRepeater::make(),
                            ]),


                        Group::make()
                            ->schema([
                                ToggleButtons::make('is_company')
                                    ->boolean()
                                    ->required()
                                    ->grouped()
                                    ->default(false)
                                    ->colors([
                                        true => 'gray',
                                        false => 'gray',
                                    ])
                                    ->inlineLabel()
                                    ->label('É uma empresa?'),

                                Section::make('Agrupe e Organize seus Contatos')
                                    ->icon(Phosphor::UsersFour)
                                    ->columnSpanFull()
                                    ->schema([
                                        Text::make('As opções são pré-definidas pela Go Imobil para que os relatórios sejam consistentes e assertivos, entre em contato para sugerir novas opções'),

                                        Select::make('categories')
                                            ->relationship(name: 'categories', titleAttribute: 'title')
                                            ->searchable(['title'])
                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "<span class='grid'><span>{$record->title}</span> <span class=\"text-xs flex opacity-50\">{$record->description}</span></span>")
                                            ->allowHtml()
                                            ->preload()
                                            ->multiple()
                                            ->searchDebounce(300)
                                            ->label('Categorias'),
                                    ]),

                                Section::make('Origem do Contato')
                                    ->icon(Phosphor::ShoppingBag)
                                    ->columnSpanFull()
                                    ->schema([
                                        Select::make('utm_source_id')
                                            ->required()
                                            ->relationship(name: 'utmSource', titleAttribute: 'title')
                                            ->searchable(['title'])
                                            ->preload()
                                            ->default(1)
                                            ->searchDebounce(400)
                                            ->label('Canal de Origem'),

                                        TextInput::make('utm_source_uri_or_detail')
                                            ->columnSpanFull()
                                            ->label('Detalhes/URI de Origem'),
                                    ]),

                                RichEditor::make('info')
                                    ->lazy()
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'link'],
                                        ['h2', 'bulletList', 'orderedList'],
                                    ])
                                    ->floatingToolbars([
                                        'paragraph' => [
                                            'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript',
                                        ],
                                        'heading' => [
                                            'h2', 'h3',
                                        ]
                                    ])
                                    ->label('Informações Adicionais'),

                                MigrationMetadataTextEntry::make(),
                            ]),
                    ]),


            ]);
    }
}
