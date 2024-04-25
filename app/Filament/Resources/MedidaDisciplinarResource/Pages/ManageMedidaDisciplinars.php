<?php

namespace App\Filament\Resources\MedidaDisciplinarResource\Pages;

use App\Filament\Resources\MedidaDisciplinarResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMedidaDisciplinars extends ManageRecords
{
    protected static string $resource = MedidaDisciplinarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Medida Disciplinar'),
        ];
    }
}
