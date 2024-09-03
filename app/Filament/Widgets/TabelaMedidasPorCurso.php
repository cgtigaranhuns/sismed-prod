<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MedidaDisciplinarResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TabelaMedidasPorCurso extends BaseWidget
{
    public static function canView(): bool
    {

        /** @var \App\Models\User */
        $authUser =  auth()->user();

        if ($authUser->hasRole(['Administrador','TI','CAEE'])) {
            return true;
        } else {
            return false;
        }
    }
    
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Medidas Disciplinares por Discente';


    public function table(Table $table): Table
    {
        
        return $table
       
            
            ->query(MedidaDisciplinarResource::getEloquentQuery()->select('discente_id',  DB::raw('COUNT(ID) as id'),)->groupBY('discente_id')->orderBy('id', 'desc'))
            
            ->columns([
                Tables\Columns\TextColumn::make('discente.name'),
                Tables\Columns\TextColumn::make('id')
                    ->alignCenter()
                    ->label('Total'),
                Tables\Columns\TextColumn::make('discente.curso.nome'),
                
            ])->defaultPaginationPageOption(5);           
    }
}
