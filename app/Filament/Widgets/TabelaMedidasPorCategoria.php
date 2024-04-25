<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MedidaDisciplinarResource;
use App\Models\MedidaDisciplinar;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TabelaMedidasPorCategoria extends BaseWidget
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
   protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    protected static ?string $heading = 'Medidas Disciplinares por Categoria';

    public function table(Table $table): Table
    {
        return $table
                 
            ->query(MedidaDisciplinarResource::getEloquentQuery()->select('categoria_id',  DB::raw('COUNT(ID) as id'),)->groupBY('categoria_id')->orderBy('categoria_id'))
            
            ->columns([
                Tables\Columns\TextColumn::make('categoria.nome'),
                    
                Tables\Columns\TextColumn::make('id')
                    ->label('Total'),
                   
            ]);
           
    }
}
