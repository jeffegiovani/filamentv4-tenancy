<?php

namespace App\Filament\Go\Resources\Contacts\Schemas\Forms;

use Filament\Forms\Components\Repeater;

class DefaultContactsRepeater extends Repeater
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->columnSpanFull()
            ->hiddenLabel()
            ->defaultItems(0)
            ->deletable()
            ->reorderable()
            ->cloneable();
    }

}
