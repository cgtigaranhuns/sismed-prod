<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenalidadeResource\Pages;
use App\Filament\Resources\PenalidadeResource\RelationManagers;
use App\Models\Penalidade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenalidadeResource extends Resource
{
    protected static ?string $model = Penalidade::class;

    protected static ?string $navigationIcon = 'heroicon-s-scale';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Penalidades';

    protected static ?string $modelLabel = 'Penalidades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenalidades::route('/'),
        ];
    }
}