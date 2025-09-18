<?php

namespace App\Filament\Go\Resources\Contacts\Schemas\Forms;

use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Schemas\Infolists\DragToOrderTextInfo;
use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;

class EmailsRepeater
{
    public static function make(): Section
    {
        return Section::make('Emails')
            ->compact()
            ->columnSpanFull()
            ->icon(Phosphor::EnvelopeSimple)
            ->collapsible()
            ->schema([
                DragToOrderTextInfo::make()
                    ->hiddenJs(<<<'JS'
                        Object.keys($get('emails') || {}).length < 2
                        JS
                    ),

                DefaultContactsRepeater::make('emails')
                    ->addAction(
                        fn(Action $action, $state) => $action
                            ->label('Adicionar Email')
                            ->icon(Phosphor::PlusBold)
                    )
                    ->deleteAction(function (Action $action) {
                        return $action->requiresConfirmation(function ($arguments, $component): bool {
                            $itemData = $component->getRawItemState($arguments['item']);

                            return !blank($itemData['value']);
                        });
                    })
                    ->itemLabel(fn(array $state): ?string => $state['value'] ?? 'Informe um email')
                    ->table([
                        TableColumn::make('Marcador')
                            ->width('30%'),
                        TableColumn::make('Email')
                            ->width('70%'),
                    ])
                    ->schema([
                        Select::make('label')
                            ->options([
                                'Pessoal' => 'Pessoal',
                                'Corporativo' => 'Corporativo',
                                'Outro' => 'Outro',
                            ])
                            ->default('Pessoal')
                            ->selectablePlaceholder(false)
                            ->required()
                            ->label('Marcador'),

                        TextInput::make('value')
                            ->required()
                            ->maxLength(80)
                            ->validationAttribute('e-mail')
                            ->rules([
                                'email:rfc,dns'
                            ])
                            ->distinct()
                            ->label('Email'),
                    ]),
            ]);
    }
}
