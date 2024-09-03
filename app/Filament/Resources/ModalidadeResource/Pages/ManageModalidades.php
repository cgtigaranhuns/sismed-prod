<?php

namespace App\Filament\Resources\ModalidadeResource\Pages;

use App\Filament\Resources\ModalidadeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageModalidades extends ManageRecords
{
    protected static string $resource = ModalidadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Modalidade'),
        ];
    }
}
