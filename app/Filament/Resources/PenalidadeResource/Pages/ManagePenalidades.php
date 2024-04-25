<?php

namespace App\Filament\Resources\PenalidadeResource\Pages;

use App\Filament\Resources\PenalidadeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenalidades extends ManageRecords
{
    protected static string $resource = PenalidadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Penalidade'),
        ];
    }
}
