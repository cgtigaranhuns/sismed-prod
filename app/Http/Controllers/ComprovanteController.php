<?php

namespace App\Http\Controllers;

use App\Models\MedidaDisciplinar;
use App\Models\Discente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ComprovanteController extends Controller
{
    public function print($id)
    {
        $md = MedidaDisciplinar::find($id);

        $nomeDiscente = !empty($md->discente?->name) ? $md->discente->name : null;
        $matriculaDiscente = !empty($md->discente?->username) ? $md->discente->username : null;
        $cursoDiscente = !empty($md->discente?->curso?->nome) ? $md->discente->curso->nome : null;
        $turnoDiscente = !empty($md->discente?->turno?->nome) ? $md->discente->turno->nome : null;
        $modalidadeDiscente = !empty($md->discente?->modalidade?->nome) ? $md->discente->modalidade->nome : null;
        $nomePenalidade = !empty($md->penalidade?->nome) ? $md->penalidade->nome : null;
        $nomeCategoria = !empty($md->categoria?->nome) ? $md->categoria->nome : null;
        $periodoDiscente = !empty($md->discente?->periodo?->nome) ? $md->discente->periodo->nome : null;

        $nivel = match ($md->nivel) {
            1 => 'LEVE',
            2 => 'MÉDIO',
            default => 'GRAVE',
        };

        // Busca todos os discentes do grupo, se houver
        $grupoDiscentes = [];
        if (empty($nomeDiscente) && !empty($md->grupo_discente_id) && is_array($md->grupo_discente_id)) {
            $grupoDiscentes = Discente::whereIn('id', $md->grupo_discente_id)->get();
        }

        return Pdf::loadView('pdf.Comprovante', compact([
            'md',
            'nomeDiscente',
            'matriculaDiscente',
            'cursoDiscente',
            'turnoDiscente',
            'modalidadeDiscente',
            'nomePenalidade',
            'nomeCategoria',
            'periodoDiscente',
            'nivel',
            'grupoDiscentes'
        ]))->stream();
    }
}