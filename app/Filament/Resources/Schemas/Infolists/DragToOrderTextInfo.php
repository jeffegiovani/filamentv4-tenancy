<?php

namespace App\Filament\Resources\Schemas\Infolists;

use ToneGabes\Filament\Icons\Enums\Phosphor;
use Filament\Schemas\Components\Text;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\HtmlString;

class DragToOrderTextInfo
{
    public static function make()
    {
        return Text::make(new HtmlString('Arraste os items para <strong>ordenar por prioridade</strong>'))
            ->size(TextSize::ExtraSmall);
    }
}
