<?php

namespace App\Filament\Go\Resources\Contacts\Schemas\Forms;

use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\Schemas\Infolists\DragToOrderTextInfo;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;

class DocumentsRepeater
{
    public static function make(): Section
    {
        return Section::make('Documentos')
            ->compact()
            ->columnSpanFull()
            ->icon(Phosphor::FileDoc)
            ->collapsible()
            ->schema([
                DragToOrderTextInfo::make()
                    ->hiddenJs(<<<'JS'
                        Object.keys($get('identification_documents') || {}).length < 2
                        JS
                    ),

                DefaultContactsRepeater::make('identification_documents')
                    ->addAction(
                        fn(Action $action, $state) => $action
                            ->label('Adicionar Documento')
                            ->icon(Phosphor::PlusBold)
                    )
                    ->deleteAction(function (Action $action) {
                        return $action->requiresConfirmation(function ($arguments, $component): bool {
                            $itemData = $component->getRawItemState($arguments['item']);

                            return !blank($itemData['label']) || !blank($itemData['value']);
                        });
                    })
                    ->itemLabel(fn(array $state): ?string => $state['value'] ?? 'Informe um documento')
                    ->table([
                        TableColumn::make('Descrição')
                            ->width('15%'),
                        TableColumn::make('Cód. Documento')
                            ->width('25%'),
                        TableColumn::make('Arquivo'),
                    ])
                    ->schema([
                        TextInput::make('label')
                            ->placeholder('RG, CPF, Passaporte, etc')
                            ->required()
                            ->label('Descrição'),

                        TextInput::make('value')
                            ->required()
                            ->label('Documento'),

                        FileUpload::make('file')
                            ->label('Arquivo')
                            ->label('Nome do arquivo'),
                    ]),
            ]);
    }
}
