<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            background: #fff;
            color: #222;
            margin: 30px;
        }

        .tabela {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
            background: #fafafa;
        }

        .tabela td, .tabela th {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            font-size: 14px;
            vertical-align: top;
        }

        .tabela th {
            background: #f3f4f6;
            font-weight: bold;
        }

        fieldset {
            border: 1.5px solid #4b5563;
            border-radius: 8px;
            margin-bottom: 18px;
            padding: 18px 20px 10px 20px;
            background: #f9fafb;
        }

        legend {
            font-size: 1.1em;
            font-weight: bold;
            color: #374151;
            padding: 0 8px;
        }

        label.alinhamento {
            
            min-width: 90px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .header-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .header-title {
            font-size: 22px;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
            margin-bottom: 4px;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        }

        .header-subtitle {
            font-size: 17px;
            color: #374151;
            text-align: center;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        }

        .assinatura-table {
            margin-top: 70px;
            width: 100%;
        }

        .assinatura-table td {
            text-align: center;
            border: none;
            font-size: 14px;
        }

        .assinatura-label {
            margin-top: 8px;
            font-size: 13px;
            color: #6b7280;
        }

        .assinatura-nome {
            font-weight: bold;
            color: #1f2937;
        }

        .assinatura-linha {
            display: block;
            margin: 0 auto 6px auto;
            width: 80%;
            border-bottom: 1.5px solid #374151;
            height: 24px;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td style="width: 160px;">
                <img src="{{ asset('img/logo-ifpe.png') }}" alt="Logo" width="120" height="160">
            </td>
            <td>
                <div class="header-title">COORDENAÇÃO DE APOIO AO ENSINO E AO ESTUDANTE</div>
                <div class="header-subtitle">COMPROVANTE DE MEDIDA DISCIPLINAR</div>
            </td>
        </tr>
    </table>

    <div class="center" style="font-size: 16px; font-weight: bold; margin-bottom: 18px;">
        Medida Disciplinar nº {{$md->id}}
    </div>

    <fieldset>
        <legend>Identificação</legend>
        <table class="tabela">
            <tr>
            @if(empty($nomeDiscente) && !empty($grupoDiscentes) && count($grupoDiscentes))
                @foreach($grupoDiscentes as $discente)
                    <tr>
                        <td>
                            <label class="alinhamento">Nome:</label>
                            {{ $discente->name ?? '-' }}
                        </td>
                        <td>
                            <label class="alinhamento">Matrícula:</label>
                            {{ $discente->username ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            @else
                <td>
                    <label class="alinhamento">Nome:</label>
                    {{ $nomeDiscente ?? '-' }}
                </td>
                <td>
                    <label class="alinhamento">Matrícula:</label>
                    {{ $matriculaDiscente ?? '-' }}
                </td>
            @endif
            </tr>
            <tr>
                <td>
                    <label class="alinhamento">Curso:</label>
                    {{ $cursoDiscente ?? '-' }}
                </td>
                <td>
                    <label class="alinhamento">Turno:</label>
                    {{ $turnoDiscente ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <label class="alinhamento">Modalidade:</label>
                    {{ $modalidadeDiscente ?? '-' }}
                </td>
                <td>
                    <label class="alinhamento">Período/Ano:</label>
                    {{ $periodoDiscente ?? '-' }}
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
                    {{ $md->data ? \Carbon\Carbon::parse($md->data)->format('d/m/Y') : '-' }}
                </td>
                <td>
                    <label class="alinhamento">Hora:</label>
                    {{ $md->hora ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <label class="alinhamento">Gravidade:</label>
                    {{ $nivel ?? '-' }}
                </td>
                <td>
                    <label class="alinhamento">Penalidade:</label>
                    {{ $nomePenalidade ?? '-' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="alinhamento">Categoria:</label>
                    {{ $nomeCategoria ?? '-' }}
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
                    {{ $md->descricao ?? '-' }}
                </td>
            </tr>
        </table>
    </fieldset>

    <table class="assinatura-table">
        <tr>
            <td>
                <span class="assinatura-linha"></span>
                <div class="assinatura-label">Assinatura do Servidor</div>
                <div class="assinatura-nome">{{$md->user->name}}</div>
                <div class="assinatura-label"><b>SIAPE:</b> {{$md->user->username}}</div>
            </td>
            <td>
                @if(empty($nomeDiscente) && !empty($grupoDiscentes) && count($grupoDiscentes))
                    @foreach($grupoDiscentes as $discente)
                        <span class="assinatura-linha"></span>
                        <div class="assinatura-label">Assinatura do Discente</div>
                        <div class="assinatura-nome">{{ $discente->name ?? '-' }}</div>
                        <div class="assinatura-label"><b>Matrícula:</b> {{ $discente->username ?? '-' }}</div>
                        @if(!$loop->last)
                            <br>
                        @endif
                    @endforeach
                @else
                    <span class="assinatura-linha"></span>
                    <div class="assinatura-label">Assinatura do Discente</div>
                    <div class="assinatura-nome">{{ $md->discente->name ?? null }}</div>
                    <div class="assinatura-label"><b>Matrícula:</b> {{ $md->discente->username ?? null }}</div>
                @endif
            </td>
        </tr>
    </table>
</body>

</html>
