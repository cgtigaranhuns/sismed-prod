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
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('name')->orderBy('username'),
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name} - {$record->username}")
                    ->searchable(['name', 'username'])
                    ->afterStateUpdated(function ($state) {
                        if (!$state) return;

                        //VERIFICAR SE DISCENTE JÁ TEM REGISTRO
                        $md = MedidaDisciplinar::where('discente_id', $state)->orWhere('grupo_discentes_id', $state);
                        $md_cat = $md->orderBy('id', 'DESC')->first();
                        $cont_md = $md->count();

                        if ($cont_md > 0 && $md_cat) {
                            Notification::make()
                                ->title('ATENÇÃO')
                                ->warning()
                                ->color('danger')
                                ->body(
                                    'DISCENTE JÁ TEM <b>' . $cont_md . '</b> MEDIDA DISCIPLINAR CADASTRADA.<br> 
                                 A ÚLTIMA FOI:<br> 
                                 <b>DATA:</b>  ' . ($md_cat->data ? \Carbon\Carbon::parse($md_cat->data)->format('d/m/Y') : 'Não informada') . '<br>
                                 <b>CATEGORIA:</b> ' . ($md_cat->categoria ? $md_cat->categoria->nome : 'Não informada') . '<br>
                                 <b>PENALIDADE:</b> ' . ($md_cat->penalidade ? $md_cat->penalidade->nome : 'Não informada') . ''
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
                        
                        if (!$discente) return;

                        $matriculaDiscente = $discente->username;
                        if (!$matriculaDiscente) return;

                        $scolar = ViewAcompanhamentoAluno::where('matricula_aluno', $matriculaDiscente)
                            ->orderBy('cod_aval', 'DESC')
                            ->limit(4)
                            ->get();

                        if ($scolar && $scolar->count() > 0) {
                            $i = 5;
                            foreach ($scolar as $scolars) {
                                if (!$scolars) continue;

                                $i--;

                                Notification::make()
                                    ->title('ATENÇÃO')
                                    ->warning()
                                    ->color('danger')
                                    ->body(
                                        '<b>PERFIL DO DISCENTE NO SCOLAR</b>.<br>
                                         <b>4 ÚLTIMAS AVALIAÇÕES Nº </b>' . $i . '<br>
                                
                                PARTICIPAÇÃO: '  . ($scolars->nt_A1_participacao ?? '-') . '-'
                                            . ($scolars->nt_A2_participacao ?? '-') . '-'
                                            . ($scolars->nt_A3_participacao ?? '-') . '-'
                                            . ($scolars->nt_A4_participacao ?? '-') . '-    
                                                   <br>                                                      
                                INTERESSE: '      . ($scolars->nt_A1_interesse ?? '-') . '-'
                                            . ($scolars->nt_A2_interesse ?? '-') . '-'
                                            . ($scolars->nt_A3_interesse ?? '-') . '-'
                                            . ($scolars->nt_A4_interesse ?? '-') . '-    
                                                    <br>           
                                ORGANIZAÇÃO: '   . ($scolars->nt_A1_organizacao ?? '-') . '-'
                                            . ($scolars->nt_A2_organizacao ?? '-') . '-'
                                            . ($scolars->nt_A3_organizacao ?? '-') . '-'
                                            . ($scolars->nt_A4_organizacao ?? '-') . '-    
                                                     <br>           
                                COMPROMETIMENTO: '  . ($scolars->nt_A1_comprometimento ?? '-') . '-'
                                            . ($scolars->nt_A2_comprometimento ?? '-') . '-'
                                            . ($scolars->nt_A3_comprometimento ?? '-') . '-'
                                            . ($scolars->nt_A4_comprometimento ?? '-') . '-    
                                                      <br>           
                                DISCIPLINA: '       . ($scolars->nt_A1_disciplina ?? '-') . '-'
                                            . ($scolars->nt_A2_disciplina ?? '-') . '-'
                                            . ($scolars->nt_A3_disciplina ?? '-') . '-'
                                            . ($scolars->nt_A4_disciplina ?? '-') . '-    
                                                       <br>           
                                COOPERAÇÃO: '       . ($scolars->nt_A1_cooperacao ?? '-') . '-'
                                            . ($scolars->nt_A2_cooperacao ?? '-') . '-'
                                            . ($scolars->nt_A3_cooperacao ?? '-') . '-'
                                            . ($scolars->nt_A4_cooperacao ?? '-') . '-    
                                                        <br>'
                                    )
                                    ->persistent()
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
                        Forms\Components\Select::make('grupo_discentes_id')
                            ->label('Grupo de Discentes')
                            ->native(false)
                            ->live(debounce: 300)                            
                            ->relationship(
                                name: 'GrupoDiscente',
                                modifyQueryUsing: fn(Builder $query) => $query->orderBy('name')->orderBy('username'),
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name} - {$record->username}")
                            ->searchable(['name', 'username'])
                            ->native(false)
                            ->multiple()
                            ->afterStateUpdated(function ($state) {
                        if (empty($state)) {
                            return;
                        }

                        // VERIFICAR SE DISCENTE JÁ TEM REGISTRO
                        $discentes = is_array($state) ? $state : [$state];
                        
                        foreach ($discentes as $discenteId) {
                            $md = MedidaDisciplinar::where('discente_id', $discenteId)
                                ->orWhere('grupo_discentes_id', 'like', '%' . $discenteId . '%');
                            $md_cat = $md->orderBy('id', 'DESC')->first();
                            $cont_md = $md->count();

                            if ($cont_md > 0 && $md_cat) {
                                Notification::make()
                                    ->title('ATENÇÃO')
                                    ->warning()
                                    ->color('danger')
                                    ->body(
                                        'DISCENTE  JÁ TEM <b>' . $cont_md . '</b> MEDIDA DISCIPLINAR CADASTRADA.<br> 
                                     A ÚLTIMA FOI:<br> 
                                     <b>DATA:</b>  ' . ($md_cat->data ? \Carbon\Carbon::parse($md_cat->data)->format('d/m/Y') : 'N/A') . '<br>
                                     <b>CATEGORIA:</b> ' . ($md_cat->categoria ? $md_cat->categoria->nome : 'N/A') . '<br>
                                     <b>PENALIDADE:</b> ' . ($md_cat->penalidade ? $md_cat->penalidade->nome : 'N/A') . ''
                                    )
                                    ->actions([
                                        Action::make('Consultar')
                                            ->button()
                                            ->url(route('filament.admin.resources.medida-disciplinars.index'), shouldOpenInNewTab: true),
                                    ])
                                    ->persistent()
                                    ->send();
                            }
                        }

                        //VERIFICA NO SCOLAR 
                        $discentes = Discente::whereIn('id', $discentes)->get();

                        foreach ($discentes as $discente) {
                            if (empty($discente->username)) {
                                continue;
                            }

                            $matriculaDiscente = $discente->username;
                            $scolar = ViewAcompanhamentoAluno::where('matricula_aluno', $matriculaDiscente)
                                ->orderBy('cod_aval', 'DESC')
                                ->limit(4)
                                ->get();

                            if ($scolar->isNotEmpty()) {
                                $i = 5;
                                foreach ($scolar as $scolars) {
                                    $i--;
                                    $nomeAluno = $scolars->nome_aluno ?? 'Nome não informado';

                                    Notification::make()
                                        ->title('ATENÇÃO')
                                        ->warning()
                                        ->color('danger')
                                        ->body(
                                            '<b>PERFIL DO DISCENTE ' . $nomeAluno . ' NO SCOLAR</b>.<br>
                                             <b>4 ÚLTIMAS AVALIAÇÕES Nº </b>' . $i . '<br>
                                    
                                    PARTICIPAÇÃO: '  . ($scolars->nt_A1_participacao ?? '-') . '-'
                                                . ($scolars->nt_A2_participacao ?? '-') . '-'
                                                . ($scolars->nt_A3_participacao ?? '-') . '-'
                                                . ($scolars->nt_A4_participacao ?? '-') . '-    
                                                       <br>                                                      
                                    INTERESSE: '      . ($scolars->nt_A1_interesse ?? '-') . '-'
                                                . ($scolars->nt_A2_interesse ?? '-') . '-'
                                                . ($scolars->nt_A3_interesse ?? '-') . '-'
                                                . ($scolars->nt_A4_interesse ?? '-') . '-    
                                                        <br>           
                                    ORGANIZAÇÃO: '   . ($scolars->nt_A1_organizacao ?? '-') . '-'
                                                . ($scolars->nt_A2_organizacao ?? '-') . '-'
                                                . ($scolars->nt_A3_organizacao ?? '-') . '-'
                                                . ($scolars->nt_A4_organizacao ?? '-') . '-    
                                                         <br>           
                                    COMPROMETIMENTO: '  . ($scolars->nt_A1_comprometimento ?? '-') . '-'
                                                . ($scolars->nt_A2_comprometimento ?? '-') . '-'
                                                . ($scolars->nt_A3_comprometimento ?? '-') . '-'
                                                . ($scolars->nt_A4_comprometimento ?? '-') . '-    
                                                          <br>           
                                    DISCIPLINA: '       . ($scolars->nt_A1_disciplina ?? '-') . '-'
                                                . ($scolars->nt_A2_disciplina ?? '-') . '-'
                                                . ($scolars->nt_A3_disciplina ?? '-') . '-'
                                                . ($scolars->nt_A4_disciplina ?? '-') . '-    
                                                           <br>           
                                    COOPERAÇÃO: '       . ($scolars->nt_A1_cooperacao ?? '-') . '-'
                                                . ($scolars->nt_A2_cooperacao ?? '-') . '-'
                                                . ($scolars->nt_A3_cooperacao ?? '-') . '-'
                                                . ($scolars->nt_A4_cooperacao ?? '-') . '-    
                                                            <br>'
                                        )
                                        ->persistent()
                                        ->send();
                                }
                            }
                        }
                    })
                            ->columnSpanFull(),
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
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('nome')->orderBy('codigo'),
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nome} - {$record->codigo}")
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
            ->defaultSort('data', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('discente.name')
                    ->searchable()
                    ->label('Discente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('grupo_discentes_id')
                    ->label('Grupo de Discentes')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }
                        // Se $state for string (ex: "1,2,3"), converte para array
                        if (is_string($state)) {
                            $state = array_filter(explode(',', $state));
                        }
                        if (!is_array($state)) {
                            return '-';
                        }
                        // Busca os nomes e usernames dos discentes pelos IDs
                        $discentes = \App\Models\Discente::whereIn('id', $state)->get(['name', 'username']);
                        // Junta nome e username com quebra de linha
                        return $discentes->map(function ($discente) {
                            return "{$discente->name} - {$discente->username}";
                        })->implode('<br>');
                
                    })
                    ->html(),

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
                    ->url(fn(MedidaDisciplinar $record): string => route('imprimirMd', $record))
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
