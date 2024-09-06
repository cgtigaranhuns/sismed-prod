<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedidaDisciplinarResource\Pages;
use App\Filament\Resources\MedidaDisciplinarResource\RelationManagers;
use App\Models\Discente;
use App\Models\MedidaDisciplinar;
use App\Models\User;
use App\Models\ViewAcompanhamentoAluno;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Actions\Action;
use Filament\Tables\Filters\SelectFilter;


class MedidaDisciplinarResource extends Resource
{
    protected static ?string $model = MedidaDisciplinar::class;

    protected static ?string $navigationIcon = 'heroicon-s-swatch';

    protected static ?string $navigationGroup = 'Lançamentos';

    protected static ?string $navigationLabel = 'Medidas Disciplinares';

    protected static ?string $modelLabel = 'Medidas Disciplinares';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('discente_id')
                    ->label('Discente')
                    ->columnSpanFull()
                    ->native(false)
                    ->live()
                    ->relationship(
                        name: 'Discente',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('name')->orderBy('username'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} - {$record->username}")
                    ->searchable(['name', 'username'])
                    ->afterStateUpdated(function ($state) {

                        //VERIFICAR SE DISCENTE JÁ TEM REGISTRO

                        $md = MedidaDisciplinar::where('discente_id', $state);
                        $md_cat = $md->first();
                        $cont_md = $md->count();

                        //  dd($cont_md);
                        if ($cont_md > 0) {
                            Notification::make()
                                ->title('ATENÇÃO')
                                ->warning()
                                ->color('danger')
                                ->body(
                                    'DISCENTE JÁ TEM <b>' . $cont_md . '</b> MEDIDA DISCIPLINAR CADASTRADA.<br> 
                                 A ÚLTIMA FOI:<br> 
                                 <b>DATA:</b>  ' . \Carbon\Carbon::parse($md_cat->data)->format('d/m/Y') . '<br>
                                 <b>CATEGORIA:</b> ' . $md_cat->categoria->nome . '<br>
                                 <b>PENALIDADE:</b> ' . $md_cat->penalidade->nome . ''

                                )
                                ->actions([
                                    Action::make('Consultar')
                                        ->button()
                                        ->url(route('filament.admin.resources.medida-disciplinars.index'), shouldOpenInNewTab: true),
                                ])
                                ->persistent()
                                ->send();
                        }
                         //VERIFICA NO SCOLAR 

                         $discente = Discente::find($state);

                         $matriculaDiscente = $discente->username;
                        // dd($matriculaDiscente);
                         // $matriculaDiscente = '20141F2GR0292';
                         $scolar = ViewAcompanhamentoAluno::where('matricula_aluno', $matriculaDiscente)->orderBy('cod_aval', 'DESC')->limit(4)->get();

                         //   dd($scolar->matricula_aluno);

                         
                         if ($scolar != null) {
                            $i = 5;
                             foreach ($scolar as $scolars) {

                                  $i--;
                                
                                 Notification::make()                                 
                                     ->title('ATENÇÃO')
                                     ->warning()
                                     ->color('danger')
                                     ->body(
                                         '<b>PERFIL DO DISCENTE NO SCOLAR</b>.<br>
                                         <b>4 ÚLTIMAS AVALIAÇÕES Nº </b>'.$i.'<br>
                                
                                PARTICIPAÇÃO: '  . $scolars->nt_A1_participacao . '-'
                                             . $scolars->nt_A2_participacao . '-'
                                             . $scolars->nt_A3_participacao . '-'
                                             . $scolars->nt_A4_participacao . '-    
                                                   <br>                                                      
                                INTERESSE: '      . $scolars->nt_A1_interesse . '-'
                                             . $scolars->nt_A2_interesse . '-'
                                             . $scolars->nt_A3_interesse . '-'
                                             . $scolars->nt_A4_interesse . '-    
                                                    <br>           
                                ORGANIZAÇÃO: '   . $scolars->nt_A1_organizacao . '-'
                                             . $scolars->nt_A2_organizacao . '-'
                                             . $scolars->nt_A3_organizacao . '-'
                                             . $scolars->nt_A4_organizacao . '-    
                                                     <br>           
                                COMPROMETIMENTO: '  . $scolars->nt_A1_comprometimento . '-'
                                             . $scolars->nt_A2_comprometimento . '-'
                                             . $scolars->nt_A3_comprometimento . '-'
                                             . $scolars->nt_A4_comprometimento . '-    
                                                      <br>           
                                DISCIPLINA: '       . $scolars->nt_A1_disciplina . '-'
                                             . $scolars->nt_A2_disciplina . '-'
                                             . $scolars->nt_A3_disciplina . '-'
                                             . $scolars->nt_A4_disciplina . '-    
                                                       <br>           
                                COOPERAÇÃO: '       . $scolars->nt_A1_cooperacao . '-'
                                             . $scolars->nt_A2_cooperacao . '-'
                                             . $scolars->nt_A3_cooperacao . '-'
                                             . $scolars->nt_A4_cooperacao . '-    
                                                        <br>'           
                                 

                                     )

                                     ->persistent()
                                  //  ->duration(5000)
                                     ->send();
                                    
                             }
                         }                         
                         
                         
                    })
                    ->editOptionForm([

                        Fieldset::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 3,
                            ])->schema([
                                Forms\Components\DatePicker::make('data_nascimento')
                                    ->label('Data Nascimento')
                                    ->live(debounce: 300)
                                    ->afterStateUpdated(function (Set $set, $state, $get) {
                                        $idade = Carbon::parse($state)->age;
                                        $set('idade', $idade);
                                    }),
                                
                                Forms\Components\Select::make('curso_id')
                                    ->relationship(name: 'curso', titleAttribute: 'nome'),
                                Forms\Components\Select::make('periodo_id')
                                    ->label('Período/Ano')
                                    ->relationship(name: 'periodo', titleAttribute: 'nome'),
                                Forms\Components\Select::make('turno_id')
                                    ->relationship(name: 'turno', titleAttribute: 'nome'),
                                Forms\Components\Select::make('modalidade_id')
                                    ->relationship(name: 'modalidade', titleAttribute: 'nome'),
                                Forms\Components\TextInput::make('idade')
                                    ->readOnly()
                                    ->extraInputAttributes(['style' => 'font-weight: bolder; font-size: 1rem; color: #1E90FF;'])
                                    ->numeric(),
                            ]),
                    ]),



                Grid::make([
                    'sm' => 3,
                    'xl' => 3,
                ])

                    ->schema([
                        Forms\Components\DatePicker::make('data')
                            ->default(now())
                            ->required(),
                        Forms\Components\TimePicker::make('hora')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('nivel')
                            ->required()
                            ->options([
                                '1' => 'LEVE',
                                '2' => 'MÉDIO',
                                '3' => 'GRAVE',
                            ])
                            ->native(false),
                    ]),
                Forms\Components\Select::make('penalidade_id')
                    ->relationship(name: 'penalidade', titleAttribute: 'nome')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Cadastrante')
                    ->disabled()
                    ->required(true)
                    ->native(false)
                    ->default(auth()->user()->id)
                    ->relationship(name: 'user', titleAttribute: 'name'),

                Forms\Components\Select::make('categoria_id')
                    ->relationship(
                        name: 'Categoria',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('nome')->orderBy('codigo'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nome} - {$record->codigo}")
                    ->searchable(['nome', 'codigo'])
                    ->columnSpanFull()
                    ->native(false)
                    ->required(),

                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição')
                    ->autosize()
                    ->required()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('discente.name')
                    ->searchable()
                    ->label('Discente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora'),
                Tables\Columns\TextColumn::make('penalidade.nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categoria.nome')
                    ->sortable(),
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
                
            SelectFilter::make('discente')->searchable()->relationship('discente', 'name'),
            SelectFilter::make('penalidade')->searchable()->relationship('penalidade', 'nome'),
            SelectFilter::make('categoria')->searchable()->relationship('categoria', 'nome'),
            Tables\Filters\Filter::make('datas')
                ->form([
                    DatePicker::make('data_ocorrencia_de')
                        ->label('Data de:'),
                    DatePicker::make('data_ocorrencia_ate')
                        ->label('Data ate:'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when(
                            $data['data_ocorrencia_de'],
                            fn($query) => $query->whereDate('data', '>=', $data['data_ocorrencia_de'])
                        )
                        ->when(
                            $data['data_ocorrencia_ate'],
                            fn($query) => $query->whereDate('data', '<=', $data['data_ocorrencia_ate'])
                        );
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Imprimir_md')
                    ->label('Imprimir Comprovante')
                    ->url(fn (MedidaDisciplinar $record): string => route('imprimirMd', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ManageMedidaDisciplinars::route('/'),
        ];
    }
}
