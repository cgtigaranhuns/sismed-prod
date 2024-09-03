<?php

namespace App\Http\Controllers;

use App\Models\MedidaDisciplinar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ComprovanteController extends Controller
{
   public function print($id) {

    $md = MedidaDisciplinar::find($id);

   // dd($md);
   // dd($id);
    $nomeDiscente = $md->Discente->name;
    $matriculaDiscente = $md->Discente->username;
    $cursoDiscente = $md->discente->curso->nome;
    $turnoDiscente = $md->Discente->turno->nome;
    $modalidadeDiscente = $md->Discente->modalidade->nome;
    $nomePenalidade = $md->penalidade->nome;
    $nomeCategoria = $md->categoria->nome;
    $periodoDiscente = $md->discente->periodo->nome;

    if($md->nivel == 1) {
      $nivel = 'LEVE';
    }elseif($md->nivel == 2) {
      $nivel = 'MÉDIO';
    }else {
      $nivel =  'GRAVE';
    }


   // dd($md->discente->periodo);


    return Pdf::loadView('pdf.Comprovante', compact(['md','nomeDiscente','matriculaDiscente','cursoDiscente','turnoDiscente','modalidadeDiscente','nomePenalidade','nomeCategoria','periodoDiscente','nivel']))->stream();

   }
}
