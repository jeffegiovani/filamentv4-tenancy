<?php

namespace App\Filament\Go\Resources\Contacts\Schemas\Forms;

use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Schemas\Infolists\DragToOrderTextInfo;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class UrlsRepeater
{
    public static function make(): Section
    {
        return Section::make('Sites e endereços web')
            ->compact()
            ->columnSpanFull()
            ->icon(Phosphor::Globe)
            ->collapsible()
            ->schema([
                DragToOrderTextInfo::make()
                    ->hiddenJs(<<<'JS'
                        Object.keys($get('urls') || {}).length < 2
                        JS
                    ),

                DefaultContactsRepeater::make('urls')
                    ->addAction(
                        fn(Action $action, $state) => $action
                            ->label('Adicionar Site/URL')
                            ->icon(Phosphor::PlusBold)
                    )
                    ->deleteAction(function (Action $action) {
                        return $action->requiresConfirmation(function ($arguments, $component): bool {
                            $itemData = $component->getRawItemState($arguments['item']);

                            return !blank($itemData['label']) || !blank($itemData['value']);
                        });
                    })
                    ->itemLabel(fn(array $state): ?string => $state['label'] ?? 'Informe um título/label')
                    ->table([
                        TableColumn::make('Descrição')
                            ->width('30%'),
                        TableColumn::make('Url/Link')
                            ->width('70%'),
                    ])
                    ->schema([
                        TextInput::make('label')
                            ->required()
                            ->maxLength(80)
                            ->placeholder('Ex: Instagram, Site da empresa, YouTube, etc')
                            ->label('Título/Label'),

                        TextInput::make('value')
                            ->required()
                            ->url()
                            ->validationAttribute('endereço web')
                            ->maxLength(200)
                            ->distinct()
                            ->placeholder('Completo com https://')
                            ->label('Email'),
                    ]),
            ]);
    }
}
