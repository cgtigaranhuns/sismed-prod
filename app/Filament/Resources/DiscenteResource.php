<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscenteResource\Pages;
use App\Filament\Resources\DiscenteResource\RelationManagers;
use App\Models\Discente;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscenteResource extends Resource
{
    protected static ?string $model = Discente::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Discentes';

    protected static ?string $modelLabel = 'Discentes';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->columns([
                    'sm' => 5,
                    'xl' => 5,
                ])->schema([
            Forms\Components\TextInput::make('name')
                ->columnSpan('2')
                ->label('Nome')
                ->maxLength(60),
            Forms\Components\TextInput::make('username')
                ->label('Matrícula')
                ->maxLength(20),
            Forms\Components\TextInput::make('mail')
                ->columnSpan('2')
                ->label('Email')
                ->maxLength(255),
            Forms\Components\DatePicker::make('data_nascimento')
                ->label('Data Nascimento')
                ->live(debounce: 300)
                ->afterStateUpdated(function (Set $set, $state, $get) {
                    $idade = Carbon::parse($state)->age;
                    $set('idade', $idade);
                }),
            Forms\Components\TextInput::make('idade')
                ->readOnly()
                ->extraInputAttributes(['style' => 'font-weight: bolder; font-size: 1rem; color: #1E90FF;'])
                ->numeric(),
            Forms\Components\Select::make('curso_id')
                    ->relationship(name: 'curso', titleAttribute: 'nome'),
            Forms\Components\Select::make('periodo_id')
                    ->label('Período/Ano')
                    ->relationship(name: 'periodo', titleAttribute: 'nome'),
            Forms\Components\Select::make('turno_id')
                    ->relationship(name: 'turno', titleAttribute: 'nome'),
            Forms\Components\Select::make('modalidade_id')
                ->relationship(name: 'modalidade', titleAttribute: 'nome'),
            
             ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label('Matrícula')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_nascimento')
                    ->date('d/m/Y')
                    ->label('Data Nascimento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('idade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('turno.nome')
                    ->sortable(),
                Tables\Columns\TextColumn::make('curso.nome')
                    ->sortable(),
                Tables\Columns\TextColumn::make('modalidade.nome')
                     ->sortable(),
               
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
            'index' => Pages\ManageDiscentes::route('/'),
        ];
    }
}
