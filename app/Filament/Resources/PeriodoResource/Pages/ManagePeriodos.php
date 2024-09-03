<?php

namespace App\Filament\Resources\PeriodoResource\Pages;

use App\Filament\Resources\PeriodoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePeriodos extends ManageRecords
{
    protected static string $resource = PeriodoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Período'),
        ];
    }
}
