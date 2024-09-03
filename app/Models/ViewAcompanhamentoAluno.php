<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewAcompanhamentoAluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula_aluno',
        'nome_aluno',
        'nt_A1_participacao',
        'nt_A1_interesse',
        'nt_A1_organizacao',
        'nt_A1_comprometimento',
        'nt_A1_disciplina',
        'nt_A1_cooperacao',
        'nt_A1_observacao',
        'nt_A2_participacao',
        'nt_A2_interesse',
        'nt_A2_organizacao',
        'nt_A2_comprometimento',
        'nt_A2_disciplina',
        'nt_A2_cooperacao',
        'nt_A2_observacao',
        'nt_A3_participacao',
        'nt_A3_interesse',
        'nt_A3_organizacao',
        'nt_A3_comprometimento',
        'nt_A3_disciplina',
        'nt_A3_cooperacao',
        'nt_A3_observacao',
        'nt_A4_participacao',
        'nt_A4_interesse',
        'nt_A4_organizacao',
        'nt_A4_comprometimento',
        'nt_A4_disciplina',
        'nt_A4_cooperacao',
        'nt_A4_observacao',
        'obs_aluno',
        'cod_aval',
        'data_realiza_A1',
        'data_realiza_A2',
        'data_realiza_A3',
        'data_realiza_A4'
    ];
}
