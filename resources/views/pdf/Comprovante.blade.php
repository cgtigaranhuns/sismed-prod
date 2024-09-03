<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .tabela {
            border: 1px;
            border-style: ;
            border-color: grey;
            width: 100%;
            margin-top: 0%;
            font-family: courier, Arial, Helvetica, sans-serif;
        }

        .alinhamento {
            text-align-last: right;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.8;
            align-items: flex-end;

        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td><img src="{{ asset('img/logo-ifpe.png') }}" alt="Logo" width="150" height="200"></td>
            <td>
                <p style="width: 100%; font-size:20px; font-family: 'courier,arial,helvetica font-weight: bold;"
                    align="center">COORDENAÇÃO DE APOIO AO ENSINO E AO ESTUDANTE</p>
                <p style="width: 100%; font-size:18px; font-family: 'courier,arial,helvetica font-weight: bold;"
                    align="center">COMPROVANTE DE MEDIDA DISCIPLINAR</p>
            </td>
        </tr>
    </table>

            <div align="center">Medida Disciplinar nº {{$md->id}}</div>

    <fieldset>
        <legend>Identificação</legend>
        <table class="tabela">
            <tr>
                <td>
                    <label class="alinhamento">Nome:</label>
                    {{ $nomeDiscente }}
                </td>
                <td>
                    <label class="alinhamento">Matrícula:</label>
                    {{ $matriculaDiscente }}
                </td>
            <tr>
                <td>
                    <label class="alinhamento">Curso:</label>
                    {{ $cursoDiscente }}
                </td>
                <td>
                    <label class="alinhamento">Turno:</label>
                    {{ $turnoDiscente }}
                </td>
            </tr>
            <tr>
                <td>
                    <label class="alinhamento">Modalidade:</label>
                    {{ $modalidadeDiscente }}
                </td>
                <td>
                    <label class="alinhamento">Período/Ano:</label>
                    {{ $periodoDiscente }}
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend>Informações do Caso</legend>
        <table class="tabela">
            <tr>
                <td>
                    <label class="alinhamento">Data:</label>
                    {{ \Carbon\Carbon::parse($md->data)->format('d/m/Y') }}
                </td>
                <td>
                    <label class="alinhamento">Hora:</label>
                    {{ $md->hora }}
                </td>
            <tr>
                <td>
                    <label class="alinhamento">Gravidade:</label>
                    {{ $nivel }}
                </td>
                <td>
                    <label class="alinhamento">Penalidade:</label>
                    {{ $nomePenalidade }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="alinhamento">Categoria:</label>
                    {{ $nomeCategoria }}
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend>Detalhes do Caso</legend>
        <table class="tabela">
            <tr>
                <td>
                    <label class="alinhamento">Descrição:</label>
                    {{ $md->descricao }}
                </td>
            </tr>
        </table>
    </fieldset>


    <table style="margin-top: 210px; width: 100%;  font-family: courier,arial,helvetica;">
        <tr>
            <td style="text-align: center;">
                ____________________________________<br>
                <label>Assinatura do Servidor</label><br>
                <label><b>{{$md->user->name}}</b></label><br>
                <label><b>SIAPE:</b>{{$md->user->username}}</label>

            </td>
            <td style="text-align: center;">

                ____________________________________<br>
                <label>Assinatura do Discente</label><br>
                <label><b>{{$md->discente->name}}</b></label><br>
                <label><b>Matrícula:</b>{{$md->discente->username}}</label>




            </td>
        </tr>
    </table>




</body>

</html>
